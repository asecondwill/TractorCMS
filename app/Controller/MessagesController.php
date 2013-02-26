<?php
class MessagesController extends AppController {

	var $name = 'Messages';

	var $permissions = array(
        'admin_index' => array('Editor'),
        'admin_add' => array('Editor'),
        'admin_edit' => array('Editor'),
        'admin_delete' => array('Editor'),                 
          'admin_order' => array('Editor'),                 
    );
    
	function admin_index() {
		$this->Message->recursive = 1;
		$this->set('messages', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s'), 'message'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('message', $this->Message->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->request->data)) {
			$this->Message->create();
			if ($this->Message->save($this->request->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved'), 'message'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.'), 'message'));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s'), 'message'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Message->save($this->request->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved'), 'message'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.'), 'message'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Message->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s'), 'message'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Message->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted'), 'Message'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted'), 'Message'));
		$this->redirect(array('action' => 'index'));
	}
}
?>