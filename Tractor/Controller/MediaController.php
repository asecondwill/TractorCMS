<?php
App::uses('CakeSession', 'Model/Datasource');
/*******************************************************************************************************
*	Powered by tractor CMS. Copyright aSecondSystem.com
*
*	Usage granted for one domain and website.
*
*	Not for resale or distribution or any other use without permission from the authors. 
*
********************************************************************************************************/
class MediaController extends AppController {

	var $name = 'Media';
	var $helpers = array('Html', 'Form', 'Time', 'Number', 'Image', 'Js');
	var $components    = array('Cookie', 'RequestHandler');
	var $paginate = array('limit' => 20, 'page' => 1, 'order'=>array('created'=>'desc')); 
	var $typesArray = array('gif', 'jpg', 'png', 'mp3', 'pdf', 'doc', 'docx', 'ppt', 'ics');
	
	function beforeFilter() {			
	 	if($this->action=='upload'){	 		 		
		    CakeSession::id($this->params['pass'][0]);
            CakeSession::start();          
       	}               
        parent::beforeFilter();                
    } 
		
	function admin_listing(){

		$this->paginate['limit']  = 3;
	   
		//
		
		// debug($this->request->named);
		
	  	$this->set('model', $this->request->named['model']);
	  	$this->set('field', $this->request->named['field']);
	  	
	    $this->Media->recursive = 0;
	   
	   	$filter=array();
	   	
	    if (!empty($this->request->named['types'])) {
			$filter['type'] = 	$this->request->named['types'];
	    	$this->set('types', $this->request->named['types']);	
	    }
	    
	    
	    
	    
	    if (!empty($this->passedArgs['width'])) {
	    	$filter['width'] = 	$this->passedArgs['width'];
	    	$this->set('width', $this->passedArgs['width']);	
	    }
	    if (!empty($this->params['width'])) {
	    	$filter['width'] = 	$this->params['width'];
	    	$this->set('width', $this->params['width']);	
	    }
	    if (!empty($this->passedArgs['width_max'])) {
	    	$filter['width <='] = 	$this->passedArgs['width_max'];
	    	$this->set('width_max', $this->passedArgs['width_max']);	
	    }
	    if (!empty($this->params['width_max'])) {
	    	$filter['width <='] = 	$this->params['width_max'];
	    	$this->set('width_max', $this->params['width_max']);	
	    }
	    
	    
	    if (!empty($this->passedArgs['height_max'])) {
	    	$filter['height <='] = 	$this->passedArgs['height_max'];
	    	$this->set('height_max', $this->passedArgs['height_max']);	
	    }
	    if (!empty($this->params['height_max'])) {
	    	$filter['height <='] = 	$this->params['height_max'];
	    	$this->set('height_max', $this->params['height_max']);	
	    }	    
	    if (!empty($this->passedArgs['height'])) {
	    	$filter['height'] = 	$this->passedArgs['height'];
	    	$this->set('height', $this->passedArgs['height']);	
	    }
	    if (!empty($this->params['height'])) {
	    	$filter['height'] = 	$this->params['height'];
	    	$this->set('height', $this->params['height']);	
	    }
	    
	    
	    
	   // debug($filter);
	   
	    $medias = $this->Paginate($filter);
	    $this->set('medias', $medias);

	
	    
	
	}	

	function admin_pick_image($type='jpg', $field_name){
		Configure::write('debug', 0);
		$this->layout = 'ajax';
		$this->Media->recursive = 1;
		$type_array = explode(",",$type);
		$medias = $this->Media->find('all', array('order'=>'created', 'conditions'=>array('type'=> $type_array)));
		$this->set('medias', $medias);
		$this->set('field_name', $field_name);
	}


	function admin_pick($file_type='jpg', $field_name ='images', $selected=''){
 		Configure::write('debug', 0);
		$this->set('file_type', $file_type);
		$filter = array('type'=>$file_type);
		$this->Content->recursive = 0;
		
		$selected_array = explode(',', $selected);
		$selected_images = array();
		foreach($selected_array as $selected_image){
			$selected_element = $this->Media->find('first', array('conditions'=>array('Media.id'=>$selected_image)));
			if ($selected_element)$selected_images[] = $selected_element;
		}
		

		
		$this->set('images', $this->paginate('Media', $filter));
		$this->set('file_type', $file_type);
		$this->set('selected_images', $selected_images);
		$this->set('field_name', $field_name);
		
		$this->render('admin_pick');
	}




	function admin_index() {
	
		

		$this->set('session_id', CakeSession::id());
	
		$this->Media->recursive = 1;
		
		
		if(isset($this->params['named']['sort'])) { // user clicked on a "sort by" link, write his choice to the session
		  $this->Session->write('media_sort',array($this->params['named']['sort']=>$this->params['named']['direction']));
		}
		elseif($this->Session->check('media_sort')) { // user has "saved" his sorting preference before
		  $this->paginate['order'] = $this->Session->read('media_sort');
		}
		
		if(isset($this->params['named']['page'])) { // user clicked on a "page" link, write his choice to the session
		  $this->Session->write('media_page',$this->params['named']['page']);
		}
		elseif($this->Session->check('media_page')) { // user has "saved" his page preference before
		  $this->paginate['page'] = $this->Session->read('media_page');
		}
		
		 
		
		
		$this->set('medias', $this->paginate());
	}
	
	function admin_edit( $id = null) {
	
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Media'),	'default', array('class'=>'fail'));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Content->save($this->data)) {
				$this->Session->setFlash(__('The Media has been saved'),	'default', array('class'=>'success'));
				$this->redirect(array('action'=>'index', $this->data['Media']['content_type']));
			} else {
				$this->Session->setFlash(__('The Media could not be saved. Please, try again.'),	'default', array('class'=>'fail'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Media->read(null, $id);
		}
		
		
	}

	
	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Media'),	'default', array('class'=>'fail'));
			$this->redirect(array('action'=>'index'));
		}
		$file = $this->Media->findById($id);
		if($file){
			if ($this->Media->delete($id)) {
				$path = $_SERVER['DOCUMENT_ROOT'] . '/app/webroot/media/' . $file['Media']['filename'];
				unlink( $path);
				$this->Session->setFlash(__('Media deleted'),	'default', array('class'=>'success'));
				$this->redirect(array('action'=>'index'));
			}
		}
		
	}
	
		public function upload(){	
			
		$this->log('process_upload..');
			
		if (!empty($_FILES)) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . '/app/webroot/'  . $_REQUEST['folder'] . '/';			
			$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];			
			$fileParts  = pathinfo($_FILES['Filedata']['name']);					
			 if (!in_array(strtolower($fileParts['extension']),$this->typesArray)) {	 
				$fail_message = __('File uploadage Failed. Check file extension<br/>
				Allowed types = ', true);
				foreach($this->typesArray as $ft){
					$fail_message .= " $ft,";
				}				
				 $this->Session->setFlash($fail_message,	'default', array('class'=>'fail'));
				 
			}elseif(in_array(strtolower($fileParts['extension']),array('jpg', 'gif', 'png')) and filesize($_FILES['Filedata']['tmp_name']) >= 1024000){
				$this->Session->setFlash("Uploadage failed. Image files must be under 1Mb.",	'default', array('class'=>'fail'));	
			}else{		
				# don't overwrite
				$no_extension = substr($targetFile, 0, strlen($targetFile) - strlen($fileParts['extension']) -1); 
				$i = 1;
		        while(file_exists($targetFile)){
		            $targetFile = $no_extension . "-" . $i . '.' . $fileParts['extension'];
		            $i++;
		        }  		        
		        #move file to media dir
				move_uploaded_file($tempFile,$targetFile);		
				
				
				$size = array();
				$width = Null;
				$height = Null;
				if (in_array(strtolower($fileParts['extension']),array('jpg', 'gif', 'png'))){
					$size =  getimagesize($targetFile);
					$width = $size[0];
					$height = $size[1];
				}
												
				
				$data=array('Media'=>array('filename'=> basename($targetFile), 'size'=>filesize($targetFile), 'type'=>strtolower($fileParts['extension']), 'width' => $width, 'height' => $height));
				$this->Media->save($data);
				echo "1";					
				$this->Session->setFlash(__('File uploadage Complete'),	'default', array('class'=>'success'));
			} 
		}	
	}
	
	public function register($file_name){
		$this->log($file_name);
		$this->layout = null; // turn off the layout
		$file_name = str_replace('|sep|', DS, $file_name);
		
		$fileParts  = pathinfo($_SERVER['DOCUMENT_ROOT'] . '/app/webroot/media/' .$file_name);
		
		
		$data=array('Media'=>array('filename'=> ($file_name), 'size'=>filesize($_SERVER['DOCUMENT_ROOT'] . '/app/webroot/media/' .$file_name), 'type'=>$fileParts['extension']));
		$this->Media->save($data);
		$this->render = false;
	} 	
	   
      public function process_upload($filename) {
   		  $this->log('process_upload..');
          $refresh = "";
   
          if (file_exists("uploadify/files/".$filename) === false) {
   
              $this->Session->setFlash('The upload failed. Please try again.','default',array("class" => "notification error"));
   
          } else {
   
              $file =  file_get_contents("uploadify/files/".$filename);
 
              if (!$file) {
  
                  $this->Session->setFlash('The upload failed because the file contents is malformed</em>','default',array("class" => "notification error"));
   
              } else {
  
                  /*
  
                  * DO STUFF HERE
  
                  */
  
                  $this->Session->setFlash('The file was uploaded succesfully','default',array("class" => "notification confirm"));
  
                  $refresh = "parent.location.reload();";
  
              }
  
              /*
  
              * DELETE OR MOVE YOUR FILE HERE. MAKE SOME CHECKS BEFORE YOU DO THAT THOUGH.
  
              */
 
              unlink("uploadify/files/".$filename);
  
              $this->set("refresh",$refresh);
  
          }
  
      }



	
	}