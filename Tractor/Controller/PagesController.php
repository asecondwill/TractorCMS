<?php
class PagesController extends AppController {

	var $name = 'Pages';
	var $helpers = array('Html', 'Time', 'Js',  'Tree', 'Image', 'TextImage', 'MTree', 'TractorInputs', 'Twitter', 'Directory');
	
	var $permissions = array(
        'admin_index' => array('Editor'),
        'admin_add' => array('Editor'),
        'admin_edit' => array('Editor'),
        'admin_delete' => array('Editor'),                 
    );
	
	 function beforeFilter() { 
    	$this->Auth->allow('view',  'index'); 
    	
    	parent::beforeFilter();   
    	
    } 
	
	function view($slug = null) {
		
		# find by slug
		if (!$slug) {
			$this->Session->setFlash(sprintf(__('Invalid %s'), 'page'));
			$this->redirect(array('action' => 'index'));
		}

		
		$this->Page->recursive = 2;
		
		# get page and  content path
		$page = $this->Page->find('first', array('conditions'=>array('Content.slug' => $slug)));
		$path  = $this->Page->Content->getPath($page['Content']['id']);
		
				
		
		# set variables
		$this->set('content', $page);		
		$this->set('path', $path);		
		$this->cacheAction = true;
		
		# set the layout and view if specified. 
		if (!empty($page['Content']['layout'])) $this->layout =  basename($page['Content']['layout'], '.ctp');
		if (!empty($page['Content']['view']))$this->render(basename($page['Content']['view'], '.ctp')) ;
		
	}

	function admin_index() {
		$this->Page->recursive = 0;
		
		$this->set('pages', $this->paginate());
	}


	function admin_add() {
		if (!empty($this->data)) {
			$this->Page->create();
			$this->request->data['Content']['class_name'] = 'pages';
			$this->request->data['Content']['title'] = $this->data['Page']['title'];
			if ($this->Page->saveAll($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved'), 'page'));
				$this->redirect(array('action' => 'edit', $this->Page->id));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.'), 'page'));
			}
		}
		$tags = $this->Page->Tag->find('list');

		$content_options = $this->Page->Content->generateTreeList();

		$this->set(compact('tags', 'content_options'));
	}

	function admin_edit($id = null, $version_id = null) {
		$this->Page->id = $id; //important for read,shadow and revisions call bellow
		
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s'), 'page'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Page->saveAll($this->data)) {								
				$this->Session->setFlash(sprintf(__('The %s has been saved'), 'page'));
				$this->redirect(array('action' => 'edit', $id));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.'), 'page'));
			}
		}else {
			
			if (is_numeric($version_id)) {
			  $this->data = $this->Page->read();
          	  $shadow = $this->Page->ShadowModel->find('first',array('conditions' => array('version_id' => $version_id)));
          	  $this->data['Page'] = $shadow['Page'];
          	  
	        } else {
    	       $this->data = $this->Page->read();
        	} 
		}
		$tags = $this->Page->Tag->find('list');
		
		
		//$featured = $this->Page->Content->find('list');
		$history = $this->Page->revisions(); 
		$content_options = $this->Page->Content->generateTreeList();
		$this->set(compact(array('tags', 'history', 'content_options')));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s'), 'page'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Page->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted'), 'Page'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted'), 'Page'));
		$this->redirect(array('action' => 'index'));
	}
}
?>