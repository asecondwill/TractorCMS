<?php
/*******************************************************************************************************
*	Powered by tractor CMS. Copyright aSecondSystem.com
*
*	Usage granted for one domain and website.
*
*	Not for resale or distribution or any other use without permission from the authors. 
*
********************************************************************************************************/

class MenuItemsController extends AppController {

	var $name = 'MenuItems';
	var $helpers = array('Html', 'Form', 'TractorInputs', 'MTree');
	var $uses = array('MenuItem', 'Page', 'Menu');
	var $paginate = array(
        'limit' => 55,
        'order' => array(
            'MenuItem.order' => 'asc'
        )
    );
    
    	var $permissions = array(
        'admin_index' => array('Editor'),
        'admin_add' => array('Editor'),
        'admin_edit' => array('Editor'),
        'admin_delete' => array('Editor'),                 
          'admin_order' => array('Editor'),                 
    );
    
	
	function admin_order(){
	
		Configure::write('debug', 0);
           $this->autoRender = false;
 
           if($this->RequestHandler->isAjax()) {
           		           		
           		$fields = explode('&', $_REQUEST['ids']);
				$order  = 0;
				
				foreach($fields as $field)
				{
					$field_key_value = explode('=', $field);
					$level 		 = urldecode($field_key_value[0]);
					$id 		 = urldecode($field_key_value[1]);
					if ($id){
						$order++;											
						$data = array('MenuItem'=>array('id'=>$id, 'order'=>$order));
						$this->MenuItem->save($data);
					}	
				}
           		
             //  $this->Session->write('BeersInOurSession', $this->params['form']['id']);
           }
	}


	function admin_index($menu , $item_id = null) {
	

		if ($item_id == 'none')$item_id=null;
		
		
		if (!empty($this->data)) {
			$this->MenuItem->create();
			if ($this->MenuItem->save($this->data)) {
				$this->Session->setFlash(__('The MenuItem has been saved'));
				$this->redirect(array('action'=>'index', $menu . "/" . $item_id));
			} else {
				$this->Session->setFlash(__('The Menu Item could not be saved. Please, try again.'));
			}
		}


		
		if ($item_id){
			$this->set('selected_item', $this->MenuItem->findById( $item_id)) ;
		}
		$this->MenuItem->recursive = 0;
		$items  = $this->MenuItem->find('threaded', array('order'=>'MenuItem.parent_id, order', 'conditions'=>array('menu_id'=>$menu)));
		$this->set('items', $items);
		$filter = array();
		if ($item_id){
			$filter=array('MenuItem.parent_id'=>$item_id, 'menu_id'=>$menu);
		}else{
			$filter=array('MenuItem.parent_id'=>null, 'menu_id'=>$menu);
		}
		
		# TODO : make an ajax paginated contents selector.  check elip for how. 
		//$this->paginate['Product'] = array( 
        //	'order'=>array('Prodcut.lft asc'); 
		//); 
		//$this->data = $this->paginate(); 
		$contents = $this->Page->Content->find('all', array('order'=>array('Content.lft asc'))) 	;
			
		$this->set('pages', $contents);
		
		$this->set('menu_id', $menu);
		$this->set('menuItems', $this->paginate($filter));
		
		// menu name form
		
		if (empty($this->data)) {
			$this->data = $this->Menu->read(null, $menu);
		}
		$this->set('menu', $this->data);
	}

	
	function admin_add($menu_id = 1,$parent_id = null) {
		if ($parent_id=='none')$parent_id = null;
		if (!empty($this->data)) {
			$this->MenuItem->create();
			if ($this->MenuItem->save($this->data)) {
				$this->Session->setFlash(__('The MenuItem has been saved'));
				$this->redirect(array('action'=>'index', $menu_id . "/" . $parent_id));
			} else {
				$this->Session->setFlash(__('The MenuItem could not be saved. Please, try again.'));
			}
		}
		$lists = $this->MenuItem->List->find('list');
		$this->set(compact('lists'));
		$this->set('parent_id', $parent_id);
		$this->set('menu_id', $menu_id);
	}

	function admin_edit($menu_id = 1,$parent_id = null,$id = null) {
	if ($parent_id == 'none')$parent_id=null;
	//debug($menu_id);
	
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid MenuItem'));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {

			if ($this->MenuItem->save($this->data)) {
				$this->Session->setFlash(__('The MenuItem has been saved'));
				$this->redirect(array('action'=>'index', $menu_id . "/" . $parent_id));
			} else {
				$this->Session->setFlash(__('The MenuItem could not be saved. Please, try again.'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->MenuItem->read(null, $id);
		}
		$lists = $this->MenuItem->List->find('list');
		$this->set(compact('lists'));
		$this->set('menuItem', $this->data);
		$this->set('parent_id', $parent_id);
		$this->set('menu_id', $menu_id);
	}

	function admin_delete($id = null, $menu) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for MenuItem'));
			$this->redirect(array('action'=>'index', $menu));
		}
		if ($this->MenuItem->delete($id)) {
			$this->Session->setFlash(__('MenuItem deleted'));
			$this->redirect(array('action'=>'index', $menu));
		}
	}

}
?>