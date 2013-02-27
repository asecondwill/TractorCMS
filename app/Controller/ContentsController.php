<?php
class ContentsController extends AppController {

	var $name = 'Contents';
	var $helpers = array('Html', 'Time', 'Js',  'Tree', 'Image', 'TextImage', 'TractorInputs');
	
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

	################################################################################################################
	#	Request Actions
	################################################################################################################
	
	function url($id){
		
		$this->Content->recursive  = -1;
		$content = $this->Content->findById($id);
		
		if (!empty($content)) return $content['Content']['path']; 
	}
	
	
	################################################################################################################
	#	Admin
	################################################################################################################

	/*
		Provides a tree of site content to choose from using the link button in the editor
	*/
	function admin_editor( ) {				
		Configure::write('debug', 0);
		$filter = array();
		$content_tree = $this->Content->find('all', array(
			'order'=>array('Content.lft asc'), 
			'fields'=>array('depth', 'title', 'id', 'class_name'),
			'conditions' => $filter
			));			
		$this->set('content_tree', $content_tree);	
		$this->layout = false;	
	}
		
	
	function admin_tree( $class_name = 'all', $allowed_class_names = 'any',  $q = null) {			
		$filter = array();
	
		if ($allowed_class_names !='any'){
			$allowed_class_names = explode('%7C', $allowed_class_names);
			$filter[] = array('Content.class_name' => $allowed_class_names);
		}
		if ($q) $filter[] = array('Content.title LIKE' => "%$q%");
		
		$content_tree = $this->Content->find('all', array(
			'order'=>array('Content.lft asc'), 
			'fields'=>array('depth', 'title', 'id', 'class_name'),
			'conditions' => $filter
			));			
		$this->set('content_tree', $content_tree);
		$this->set('class_name', $class_name);
	}
	
	function admin_index() {
		
		$contents = $this->Content->find('threaded', array(
			'fields' => array('id', 'title', 'lft', 'rght', 'parent_id'), 
			'order' => 'lft ASC'
			));

     	
		$this->set('contents',$contents);

	}

	
	function admin_add($class_name = null, $action_name = null){

		if (!empty($this->request->data)) {
			$this->Content->create();
			if ($this->Content->save($this->request->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved'), 'Content'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.'), 'Content'));
			}
		}
		
		if ($class_name){
			$this->request->data['Content']['class_name'] = $class_name;
		}
		if ($action_name){
			$this->request->data['Content']['action_name'] = $action_name;
		}

		
		$content_options = $this->Content->generatetreelist();

		$this->set(compact( 'content_options'));

	}
}