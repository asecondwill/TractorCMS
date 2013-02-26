<?php
/*******************************************************************************************************
*	Powered by tractor CMS. Copyright aSecondSystem.com
*
*	Usage granted for one domain and website.
*
*	Not for resale or distribution or any other use without permission from the authors. 
*
********************************************************************************************************/
class GroupsController extends AppController {

	var $name = 'Groups';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Group->recursive = 0;
		$this->set('groups', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Group.'));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('group', $this->Group->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Group->create();
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash(__('The Group has been saved'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Group could not be saved. Please, try again.'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Group'));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash(__('The Group has been saved'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Group could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Group->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Group'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Group->delete($id)) {
			$this->Session->setFlash(__('Group deleted'));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->Group->recursive = 0;
		$this->set('groups', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Group.'));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('group', $this->Group->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->request->data)) {
			$this->Group->create();
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash(__('The Group has been saved'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Group could not be saved. Please, try again.'));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Group'));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash(__('The Group has been saved'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Group could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Group->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Group'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Group->delete($id)) {
			$this->Session->setFlash(__('Group deleted'));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>