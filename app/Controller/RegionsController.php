<?php
/*******************************************************************************************************
*	Powered by tractor CMS. Copyright aSecondSystem.com
*
*	Usage granted for one domain and website.
*
*	Not for resale or distribution or any other use without permission from the authors. 
*
********************************************************************************************************/
class RegionsController extends AppController {

	var $name = 'Regions';
	
	var $permissions = array(
        'admin_index' => array('Editor'),
        'admin_add' => array('Editor'),
        'admin_edit' => array('Editor'),
        'admin_delete' => array('Editor'),                 
    );


	function admin_index() {
		$this->Region->recursive = 0;
		$this->set('regions', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s'), 'region'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('region', $this->Region->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->request->data)) {
			$this->Region->create();
			if ($this->Region->save($this->request->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved'), 'region'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.'), 'region'));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s'), 'region'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Region->save($this->request->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved'), 'region'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.'), 'region'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Region->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s'), 'region'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Region->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted'), 'Region'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted'), 'Region'));
		$this->redirect(array('action' => 'index'));
	}
}
?>