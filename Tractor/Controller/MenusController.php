<?php
/*******************************************************************************************************
*	Powered by tractor CMS. Copyright aSecondSystem.com
*
*	Usage granted for one domain and website.
*
*	Not for resale or distribution or any other use without permission from the authors. 
*
********************************************************************************************************/
class MenusController extends AppController {	
	
	var $permissions = array(
        'admin_index' => array('Editor'),
        'admin_add' => array('Editor'),
        'admin_edit' => array('Editor'),
        'admin_delete' => array('Editor'),                 
    );
    
     function beforeFilter() { 
    	$this->Auth->allow('view'); 
    	
    	parent::beforeFilter();   
    	
    } 
    
	function admin_add() {
		if (!empty($this->data)) {
			$this->Menu->create();
			if ($this->Menu->save($this->data)) {
				$this->Session->setFlash(__('The Menu has been saved.'),	'default', array('class'=>'success'));
				$this->redirect(array('controller'=> 'menu_items' , 'action'=>'index', $this->Menu->id));
			} else {
				$this->Session->setFlash(__('The Menu could not be saved.'),	'default', array('class'=>'fail'));
			}
		}
	}
	
	function view($name = null) {

		if (!$name) return false;
		
		$this->Menu->recursive = 0;
		$menu  = $this->Menu->find('first', array('conditions'=>array('name'=>$name)));
		$items =  $this->Menu->MenuItem->find('threaded', array('order'=>'MenuItem.parent_id, order', 'conditions'=>array('menu_id'=>$menu['Menu']['id'])));	
		
		
		
		return $items;
	}

	
	function admin_edit() {
		if (!empty($this->data)) {
			
			if ($this->Menu->save($this->data)) {
				$this->Session->setFlash(__('The Menu has been saved.'),	'default', array('class'=>'success'));
				$this->redirect(array('controller'=> 'menu_items' , 'action'=>'index', $this->Menu->id));
			} else {
				$this->Session->setFlash(__('The Menu could not be saved.'),	'default', array('class'=>'fail'));
			}
		}
	}
	
		function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('The Menu has not been deleted.'),	'default', array('class'=>'fail'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Menu->delete($id)) {
			$this->Session->setFlash(__('The Menu has been deleted.'),	'default', array('class'=>'success'));
			
		}
	}
	
}