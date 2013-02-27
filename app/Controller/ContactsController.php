<?php
class ContactsController extends AppController {

	var $name = 'Contacts';
	var $helpers = array('Html', 'Time',   'Tree', 'Image', 'TextImage', 'TractorInputs', 'Number', 'Twitter');
	
	 function beforeFilter() { 
    	$this->Auth->allow(array('view', 'send_to_friend')); 
    	
    	parent::beforeFilter();   
    	
    } 
    
    
	
	function send_to_friend($slug){
		if (!$slug) {
			$this->Session->setFlash(sprintf(__('Invalid %s'), 'contact'));
			$this->redirect(array('action' => 'index'));
		}
		
		$contact = $this->Contact->find('first', array('conditions'=>array('Content.slug' => $slug)));
		$path  = $this->Contact->Content->getPath($contact['Content']['id']);
		
		
		
		if ($this->RequestHandler->isPost()) {
				$this->Contact->Message->create();

		        if ($this->Contact->Message->save($this->request->data)) {
		 		
		            //send email using the Email component
		            $this->Email->to = array(configure::read('system.email'), $this->request->data['Message']['friends_email']);
		            $this->Email->subject = 'Contact message from ' . $this->request->data['Message']['email']  ;
		            $this->Email->from = $this->request->data['Message']['email'];  		   			
		   			$message =$this->request->data['Message']['details'];		   						   			
		            $this->Email->send($message);

		            $this->Session->setFlash(__($contact['Contact']['win']),'default', array('class'=>'win'));
					
					$this->redirect($this->request->data['Message']['referer']);
		        }else{
		        	$this->Session->setFlash($contact['Contact']['fail'],'default' ,array('class'=>'fail'));		        
		        }
		}        
		
		
		$this->set('contact', $contact);		
		$this->set('path', $path);		
		$this->cacheAction = true;
	}
    
    		
	function view($slug = null) {
		
		if (!$slug) {
			$this->Session->setFlash(sprintf(__('Invalid %s'), 'contact'));
			$this->redirect(array('action' => 'index'));
		}
		
		
		

		
		$contact = $this->Contact->find('first', array('conditions'=>array('Content.slug' => $slug)));
		$path  = $this->Contact->Content->getPath($contact['Content']['id']);
		
		
		
		if ($this->RequestHandler->isPost()) {
				$this->Contact->Message->create();

		        if ($this->Contact->Message->save($this->request->data)) {
		 		
		            //send email using the Email component
		            $this->Email->to = configure::read('system.email');
		            $this->Email->subject = 'Contact message from ' . $this->request->data['Message']['email']  ;
		            $this->Email->from = $this->request->data['Message']['email'];  		   			
		   			$message =$this->request->data['Message']['details'];		   			
	
		   			
		            $this->Email->send($message);

		            $this->Session->setFlash(__($contact['Contact']['win']),'default', array('class'=>'success'));
					
					$this->redirect($this->request->here);
		        }else{
		        	$this->Session->setFlash($contact['Contact']['fail'],'default' ,array('class'=>'fail'));		        
		        }
		}        
		
		
		$this->set('contact', $contact);		
		$this->set('path', $path);		
		$this->cacheAction = true;
	}

	function admin_index() {
		$this->Contact->recursive = 0;
		
	//	$this->set('tags', $this->Contact->Tagged->find('cloud', array('limit' => 60, 'conditions'=>array('model'=>'Contact'))));
		
		$this->set('contacts', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s'), 'contact'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('contact', $this->Contact->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->request->data)) {
			$this->request->data['Content']['class_name'] = 'contacts';
			$this->Contact->create();
			if ($this->Contact->saveAll($this->request->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved'), 'contact'));
				$this->redirect(array('action' => 'edit', $this->Contact->id));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.'), 'contact'));
			}
		}
		$tags = $this->Contact->Tag->find('list');

		$content_options = $this->Contact->Content->generateTreeList();

		$this->set(compact('tags', 'content_options'));
	}

	function admin_edit($id = null, $version_id = null) {
		$this->Contact->id = $id; //important for read,shadow and revisions call bellow
		
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s'), 'contact'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {		
			if ($this->Contact->saveAll($this->request->data)) {								
				$this->Session->setFlash(sprintf(__('The %s has been saved'), 'contact'));
				$this->redirect(array('action' => 'edit', $id));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.'), 'contact'));
			}
		}else {
			
			if (is_numeric($version_id)) {
				$this->request->data = $this->Contact->read();
          	  $shadow = $this->Contact->ShadowModel->find('first',array('conditions' => array('version_id' => $version_id)));
          	  $this->request->data['Contact'] = $shadow['Contact'];
          	  
	        } else {
    	       $this->request->data = $this->Contact->read();
        	} 
		}
		$tags = $this->Contact->Tag->find('list');
				
		$history = $this->Contact->revisions(); 
		$content_options = $this->Contact->Content->generateTreeList();
		$this->set(compact(array('tags', 'history', 'content_options')));
	}




	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s'), 'contact'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Contact->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted'), 'Contact'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted'), 'Contact'));
		$this->redirect(array('action' => 'index'));
	}
}
?>