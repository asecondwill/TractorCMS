<?php
/*******************************************************************************************************
*	Powered by tractor CMS. Copyright aSecondSystem.com
*
*	Usage granted for one domain and website.
*
*	Not for resale or distribution or any other use without permission from the authors. 
*
********************************************************************************************************/
class BlocksController extends AppController {

	var $name = 'Blocks';
	var $paginate = array(
        'limit' => 55,
        'order' => array(
            'Block.weight' => 'asc'
        )
    );

	var $permissions = array(
        'admin_index' => array('Editor'),
        'admin_add' => array('Editor'),
        'admin_edit' => array('Editor'),
        'admin_delete' => array('Editor'),                 
        'admin_order' => array('Editor'),                 
    );	

	 function beforeFilter() { 
    	$this->Auth->allow('listing'); 
    	
    	parent::beforeFilter();   
    	
    } 
    	
	function region( $region = null){

		$conditions  = array('Region.title' => $region);

		$blocks = $this->Block->find('all', array('order' => 'Block.weight' , 'limit' => $limit, 'conditions' => $conditions));	

		return $blocks;	 
	}
	
	function admin_index($region_id = null) {
		$this->Block->recursive = 0;
		$filter= array();
		if($region_id) {
			$filter = array('region_id'=>$region_id);
			$region = $this->Block->Region->findById($region_id);
			$this->set('region', $region);
		}	
		$this->set('blocks', $this->paginate($filter));
		
	}

	

	function admin_add($region = null) {
		if (!empty($this->data)) {
			$this->Block->create();
			if ($this->Block->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved'), 'block'));
				$this->redirect(array('action' => 'index', $this->data['Block']['region_id']));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.'), 'block'));
			}
		}
		$regions = $this->Block->Region->find('list');
		$this->set(compact('regions', 'region'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s'), 'block'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Block->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved'), 'block'));
				$this->redirect(array('action' => 'index', $this->data['Block']['region_id']));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.'), 'block'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Block->read(null, $id);
		}
		$regions = $this->Block->Region->find('list');
		$this->set(compact('regions'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s'), 'block'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Block->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted'), 'Block'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted'), 'Block'));
		$this->redirect(array('action' => 'index'));
	}
	
	function admin_order(){
		

		Configure::write('debug', 0);
           $this->autoRender = false;
 
           if($this->RequestHandler->isAjax()) {
           		           		
           		$fields = explode('&', $_REQUEST['ids']);
				$order  = 0;

				print_r($_REQUEST['ids']);
				foreach($fields as $field)
				{


					$field_key_value = explode('=', $field);
					$level 		 = urldecode($field_key_value[0]);
					$id 		 = urldecode($field_key_value[1]);
					
					
//					echo "**" . $id . "**";
					
					if ($id){
						$order++;
						
						
						$data = array('Block'=>array('id'=>$id, 'weight'=>$order));
						$this->Block->save($data);
					}	
				}
           		
             //  $this->Session->write('BeersInOurSession', $this->params['form']['id']);
           }
	}

}
?>