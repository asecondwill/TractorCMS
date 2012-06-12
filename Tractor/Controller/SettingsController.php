<?php
/*******************************************************************************************************
*	Powered by tractor CMS. Copyright aSecondSystem.com
*
*	Usage granted for one domain and website.
*
*	Not for resale or distribution or any other use without permission from the authors. 
*
********************************************************************************************************/
class SettingsController extends AppController {
	var $name = 'Settings';
	
	var $permissions = array(
        'admin_index' => array('Editor'),
        'admin_add' => array('Editor'),
        'admin_edit' => array('Editor'),
        'admin_delete' => array('Editor'),                 
    );

	function admin_index(){

		if (!empty($this->data)) {
			if(!$this->data['Setting']['id']) $this->Setting->create();
			
			if ($this->Setting->save($this->data)) {
				$this->Session->setFlash(__('The Settings have been saved.'),	'default', array('class'=>'success'));
				

				if (is_uploaded_file($this->data['Setting']['favicon']['tmp_name'])){
					$file = new File($this->data['Setting']['favicon']['name']);
					
					$ext = $file->ext(); 
					$file->close();
					$file = new File($this->data['Setting']['favicon']['tmp_name']);
					
					
					
					if ($ext == 'ico') {
						$data = $file->read();
						$file->close();
						$file = new File(WWW_ROOT.'/favicon.ico',true);
						$file->write($data);
						$file->close();
					}else{
						$this->Session->setFlash(__('Please upload a .ico file for your favicon. You tried a ' . $ext  . ' file'  ),	'default', array('class'=>'fail'));
					}
				}
				
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Setting could not be saved.'),	'default', array('class'=>'fail'));
			}
			
			
		}
		if (empty($this->data)) {
			$this->data = $this->Setting->find();
		}
	}
	
	function admin_add() {
		if (!empty($this->data)) {
			$this->SiteText->create();
			if ($this->SiteText->save($this->data)) {
				$this->Session->setFlash(__('The Site Text has been saved.'),	'default', array('class'=>'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Site Text could not be saved.'),	'default', array('class'=>'fail'));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid SiteText'));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->SiteText->save($this->data)) {
				$this->Session->setFlash(__('The Site Text has been saved.'),	'default', array('class'=>'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Site Text could not be saved.'),	'default', array('class'=>'fail'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->SiteText->read(null, $id);
		}
	}
	
}