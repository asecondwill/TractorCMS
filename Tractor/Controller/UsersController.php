<?php
/*******************************************************************************************************
*	Powered by tractor CMS. Copyright aSecondSystem.com
*
*	Usage granted for one domain and website.
*
*	Not for resale or distribution or any other use without permission from the authors. 
*
********************************************************************************************************/
App::uses('CakeEmail', 'Network/Email');
class UsersController extends AppController {

	var $name = 'Users';
	var $helpers = array('Html', 'Form', 'Time');
	var $uses = array('User', 'Page' , 'Contact');
	var $components  = array('Email');
	
	
	var $permissions = array(
        'admin_index' => array('Editor'),
        'admin_add' => array('Editor'),
        'admin_edit' => array('Editor'),
        'admin_delete' => array('Editor'),                 
          'admin_password' => array('Editor'),                 
    );
	
	
    
    function _getContent($slug){
		$this->Page->recursive = 0;
		$content = $this->Page->findBySlug($slug);
		return $content;
    }
    function _setStandardViewVars($content, $view_var = 'content'){
    	$this->set($view_var, $content);
    }
    
    function beforeFilter() { 
    	#allow everyone this stuff. 
    	$this->Auth->allow('login', 'admin_login', 'view', 'reset', 'register', "confirm", 'subscribe', 'confirmsubscribe', 'unsubcribe', 'holding', 'holdingthanks', 'holdingconfirm', "*"); 
//		$this->Security->allowedControllers = "Pages";    	
    	parent::beforeFilter(); 
    } 
    
    
    
     function _sendReset($user){
    
    	$this->User->setValidation('basic'); 
    	$password = substr(md5(uniqid(mt_rand(), true)), 0, 8);    
    	$this->Session->setFlash(__('A new password has been sent to your email address.'),'default', array('class'=>'success'));    	
		$id= $user['User']['id'];
		$data = array('User'=>array(
									'id'=>$id, 
									'email'=>$user['User']['email'],  
									'password'=>$password
									)
					);
		
	
		$this->User->save($data);
		
		$this->set('password',$password);
		
			
		$email = new CakeEmail();
		
		
		$email->viewVars(array('user'=>$user, 'password'=>$password));
		$email->template('reset', 'default')->emailFormat('text');
		$email->from($this->settings['system_email']);
		$email->to($user['User']['email']);
		$email->subject('Password Reset');
		$email->send();
		
		$this->log($password);
    }
    function _sendConfirmation($user){
    	$this->User->setValidation('basic'); 
    	 
    	$this->Email->from    = configure::read('system.email');
    	
		$this->Email->to      = $user['User']['username'] . '<' . $user['User']['email'] . '>'; 
	
		//$user['User']['email']; //  this sends to gmail.  probably a spam thing to others preventing it. . 
		
		
		$this->Email->subject = 'Account Confirmation';
		$id= $user['User']['id'];
		$code = sha1($id);
		$code= substr($code, 0,6 );
		
		$user['User']['confirmsubscribecode'] = substr(sha1($id.'s'), 0,6 );	
		$user['User']['confirmcode'] = $code;
		$this->User->save($user);

		
		


			$this->Email->from    = configure::read('system.email');
	    	
			$this->Email->to      = $user['User']['name'] . '<' . $user['User']['email'] . '>'; 		

			$this->Email->subject = 'Confirm Registration';
			$id= $user['User']['id'];
			$code = sha1($id.'s');
			$code= substr($code, 0,6 );
			
			$user['User']['confirmcode'] = $code;
			$this->User->save($user);
	
			$this->Email->template = 'register_confirm';
			
			$this->Email->sendAs = 'both';
			
			$this->set('text_for_layout', 'error - wrong template');
			$this->set('confirm_link', "http://" . $_SERVER['HTTP_HOST'] . "/users/holdingconfirm/$code");
			$this->set('recipient', $user);
			$this->set('site', $_SERVER['HTTP_HOST'] );
			
			$this->Email->send();
		
			

    
    	$this->Session->setFlash(__('Please check your email and click the confirm link'),'default', array('class'=>'holding'));
    }



    
    
    function confirm($id = null){
    if(!$id)$this->redirect(array('url'=>'/'));
    $this->User->setValidation('basic'); 
    	$user=$this->User->findByConfirmcode($id);
    	if($user){
    		$user['User']['confirmed'] = 1;
    		$this->User->save($user);
    	
    		$this->Session->setFlash(__('Your account has been confirmed. You can now log in.'),'default', array('class'=>'success'));
    	}else{
    		$this->Session->setFlash(__('There was a problem. Please contact us.'),'default', array('class'=>'fail'));
    	}
    	
    	$this->redirect(array('action'=>'login', 'controller'=>'users'));
    	
    }
    
    
    function change(){
    	$content = $this->_getContent('users-change');
		$this->_setStandardViewVars($content);
		
    	if (!empty($this->data)) {
    		$this->User->setValidation('password'); 
    		$this->data['User']['id'] = $this->Auth->user('id');
			if ($this->User->save($this->data)) {
        	$this->Session->setFlash(__('Your password has been changed'),'default', array('class'=>'success'));
			
			//$this->redirect(array('action'=>'view', 'controller'=>'users',$this->Auth->user('id') ));
			$this->redirect("/");
			} else {
				//$this->data['User']['password'] = '';
  	$this->Session->setFlash(__('There was a problem changing the password. Please check the form.'),'default', array('class'=>'fail'));
			}
		}
    }

    
     function welcome(){
    }

    function admin_login(){
        if($this->Auth->user()){

            $this->Session->write('Auth.User.group', $this->User->Group->field('name',array('id' => $this->Auth->user('group_id'))));
            $this->redirect($this->Auth->redirect());
        }
    }
    
    function reset(){
    	
			
    	if ($this->data){
    		$user = $this->User->findByEmail($this->data['User']['email']);
			
    		if ($user){
    		
    			if($user['User']['confirmed']){
    				$this->_sendReset($user);
    			}

    			$this->redirect(array('action'=>'login', 'controller'=>'users'));
    		}
    	}
    }
    
    
    
	function login(){
        if ($this->request->is('post')) {
	        if ($this->Auth->login()) {
	            return $this->redirect($this->Auth->redirect());
	        } else {
	            $this->Session->setFlash(__('Username or password is incorrect'), 'default', array(), 'auth');
	        }
  	  	}
    }

    
    function logout(){    	
        $this->redirect($this->Auth->logout());
    } 

	


	function admin_index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid User.'));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}
	
	function view($id = null) {
		$this->User->setValidation('none'); 
		if (!$id) {
			$this->Session->setFlash(__('Invalid User.'));
			$this->redirect(array('action'=>'index' , 'controller'=>'index'));
		}
		
		$user = $this->User->findById($id);
		
		if(isset($this->data['Contact']['email'])){
			
	        $this->Contact->set($this->data);
	        if ($this->Contact->validates()) {
	            //send email using the Email component
	            $this->Email->to = $user['User']['email'];  
	            $this->Email->subject = 'Contact message from ' . $this->current_user['User']['username'];  
	            $this->Email->from = $this->data['Contact']['email'];  
	   
	            $this->Email->send($this->data['Contact']['message']);
				$this->Session->setFlash(__('Your message has been sent'),'default', array('class'=>'success'));
	            $this->redirect(array('action'=>'view', $id));
	        }
			
		}
		

		if (!empty($this->data) and isset($this->data['Link'])) {

			$this->data['Link']['user_id'] = $id;	
			if ($this->User->Link->save($this->data)) {
				$this->Session->setFlash(__('The Link has been saved'));
				$this->redirect(array('action'=>'view', $id));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.'));
			}
		}
		$this->set('user', $this->User->read(null, $id));
	}

		function link_delete($id) {

			if (!$id) {
				$this->Session->setFlash(__('Invalid id for Link'));
				$this->redirect(array('action'=>'home', 'controller'=>'pages'));
			}
			$link = $this->Link->findById($id);
			if(!$link){
				$this->redirect(array('action'=>'home', 'controller'=>'pages'));
			}
			$user=$this->Auth->user();
			if ($link['Link']['user_id'] != $user['User']['id']){
				$this->redirect(array('action'=>'home', 'controller'=>'pages'));
			} 
			
			 
			if ($this->Link->delete($id)) {
				$this->Session->setFlash(__('Link deleted'));
				$this->redirect(array('action'=>'view', $user['User']['id']));
			}

		}



	function admin_add() {
		if (!empty($this->data)) {
			
			$this->User->create();
			if ($this->User->save($this->data)) {
        	$this->Session->setFlash(__('Nice one! .'),'default', array('class'=>'success'));
			
			$this->redirect(array('action'=>'index'));
			} else {
  	$this->Session->setFlash(__('There was a problem . Please check the form. '),'default', array('class'=>'fail'));
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

	function admin_edit($id = null) {
		$this->User->setValidation('basic'); 
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User'));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved'),	'default', array('class'=>'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.'),	'default', array('class'=>'fail'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}
	
	function admin_password($id = null) {
		$this->User->setValidation('password'); 
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User'));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved'),	'default', array('class'=>'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.'),	'default', array('class'=>'fail'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
		
	}
	
	
	function edit($id = null) {
		$content = $this->_getContent('users-edit');
		$this->_setStandardViewVars($content);
		
		$this->User->setValidation('basic'); 
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User'));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved'),'default', array('class'=>'success'));
				$this->redirect(array('action'=>'view', $id));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.'),'default', array('class'=>'fail'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
		$this->set('user', $this->User->read(null, $id));
	}
function holdingthanks(){
	$this->layout = "holding";	
}

function holding() {
	$this->layout = "holding";
	
	$this->User->setValidation('holding'); 
		
		$content = $this->_getContent('users-register');
		$this->_setStandardViewVars($content);
		if (!empty($this->data)) {
			$this->data['User']['group_id'] = 8;
			$this->User->create();
			if ($this->User->save($this->data)) {
        	$this->Session->setFlash(__('Nice one! Now go check your email and click the confirmation link we just sent you.'),'default', array('class'=>'success'));
			$this->_sendConfirmation($this->User->findById($this->User->id));
			$this->redirect(array("action"=>'holdingthanks', 'controller'=>'users'));
			} else {
  	$this->Session->setFlash(__('There was a problem signing you up. Please check the form. '),'default', array('class'=>'fail'));
			}
		}
	}
	
	
function register() {
		if($this->Auth->user()){
			$this->Session->setFlash(__('You are already signed in.'),'default', array('class'=>'fail'));
			$this->redirect(array('action'=>'view', 'controller'=>'users', $this->Auth->user('id')));
		}
		$content = $this->_getContent('users-register');
		$this->_setStandardViewVars($content);
			
		if (!empty($this->data)) {
			$this->data['User']['group_id'] = 5;
			$this->User->create();
			if ($this->User->save($this->data)) {
        	$this->Session->setFlash(__('Nice one! Now go check your email and click the confirmation link we just sent you.'),'default', array('class'=>'success'));
			$this->_sendConfirmation($this->User->findById($this->User->id));
			$this->redirect(array('action'=>'login', 'controller'=>'users'));
			} else {
  	$this->Session->setFlash(__('There was a problem signing you up. Please check the form. '),'default', array('class'=>'fail'));
			}
		}
	}
	
	function unsubscribe ($email = null, $code = null){
	$this->User->setValidation('basic'); 
		if(!$email && !$code) $this->redirect('/');
		$user = $this->User->find('first', array('email'=>$email, 'confirmsubscribecode'=>$code));
		if (!$user){
			$this->Session->setFlash(__('Account not found.'),'default', array('class'=>'fail'));
			$this->redirect('/');
		}else{
			$user['User']['subscribe'] = null;
			$this->User->save($user);
			$this->redirect('/pages/view/unsubscribed');
		}
	}
	
	function subscribe (){
		$this->User->setValidation('basic'); 
		
		$user = $this->User->findByEmail($this->data['User']['email']);	
		if (!$user){
			$this->User->create();
			if ($this->User->save($this->data)) ;
			$user = $this->User->findByEmail($this->data['User']['email']);	
		}
		
			$this->Email->from    = configure::read('system.email');
	    	
			$this->Email->to      = $user['User']['name'] . '<' . $user['User']['email'] . '>'; 		

			$this->Email->subject = 'Subscribe Confirmation';
			$id= $user['User']['id'];
			$code = sha1($id.'s');
			$code= substr($code, 0,6 );
			
			$user['User']['confirmsubscribecode'] = $code;
			$this->User->save($user);
	
			$this->Email->template = 'subscribe_confirm';
			
			$this->Email->sendAs = 'both';
			
			$this->set('text_for_layout', 'error - wrong template');
			$this->set('confirm_link', "http://" . $_SERVER['HTTP_HOST'] . "/users/confirmsubscribe/$code");
			$this->set('recipient', $user);
			$this->set('site', $_SERVER['HTTP_HOST'] );
			
			$this->Email->send();
				    
	    	$this->Session->setFlash(__('You have been sent an email to confirm your subscription.'),'default', array('class'=>'success'));

		 $this->redirect('/pages/view/subscribe');
		
	}
	
	function confirmsubscribe($code = null) {
		 if(!$code)$this->redirect(array('url'=>'/'));
    $this->User->setValidation('basic'); 
    	$user=$this->User->findByConfirmsubscribecode($code);

    	if($user){
    		$user['User']['subscribe'] = 1;
    		$this->User->save($user);
    	
    		$this->Session->setFlash(__('You are now subscribed!.'),'default', array('class'=>'success'));
    		$this->redirect('/pages/view/subscribed');
    	}else{
    		$this->Session->setFlash(__('There was a problem. Please contact us.'),'default', array('class'=>'fail'));
    		$this->redirect('/pages/view/contact');
    	}
    	
    	//$this->redirect('/pages/subscribed');
	}


	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for User'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>