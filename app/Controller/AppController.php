<?php
class AppController extends Controller {
	public $components = array(
	'RequestHandler', 
	'Session', 
	'DebugKit.Toolbar', 
	'Auth' 
	);
	
	var $helpers = array('Html', 'Session', 'Form',  'Js', 'Text', 'MTree', 'Time', 'Layout', 'AssetCompress.AssetCompress', 'Cache', 'Menu', 'Tags.TagCloud', 'Twitter', 'Number');

	//var $uses = array('Setting', 'Menu', 'MenuItem',  'Content');
	
	public $viewClass = 'Theme';
	
	function beforeRender(){
		$this->set('user_for_layout', $this->Auth->user());
			
		$this->_getSettings();
		
		
		
		App::import('Model', 'Menu');	
		$Menu = new Menu;
		$Menu->recursive   = -1;
		$menus=$Menu->find('all');
		$this->set('menus_for_admin', $menus);
		
		
		App::import('Model', 'Content');	
		$Content = new Content;
		$contents = $Content->find('threaded', array(
			'fields' => array('id', 'title', 'path', 'slug',  'lft', 'rght', 'parent_id'), 
			'order' => 'lft ASC'
			));
			
		$this->set('contents',$contents);	
	
		
		
	}	 
	
	 function beforeFilter() { 
    	
    	//$this->Auth->allow();
    	
		$this->Auth->authorize = array('Controller');
  
   		 $this->Auth->authenticate = array('Form'=>array(
   		 											'userModel'	=>	'User', 
   		 											'fields'	=>	array('username'=>'email')
   		 									));
   		 $this->Auth->authError = "You are not authorised to access that location.";  		
   		 $this->Auth->loginAction =  array(
			'controller' => 'users',
			'action' => 'login',
			'plugin' => null,
			'admin'=>false
		);
		
		$this->Auth->fields  = array(
            'username'=>'email', //The field the user logs in with (eg. username)
            'password' =>'password' //The password field
        );
        
		
		$this->_getSettings();
		$this->theme = $this->settings['theme'];
		
		if (isset($this->request->params['admin'] )) {
			$this->layout = 'admin';
		}
    }
    
    function _getSettings(){
		$this->settings = Cache::read("Settings");
		if(!$this->settings){			
			
			$Setting = 			ClassRegistry::init('Setting');
			$settings = $Setting->find();  #get it?
			Cache::write('Settings', $settings['Setting']);
			$this->settings = $settings['Setting'];
		}
		
	
		
		
		# make available in views
		$this->set('settings',$this->settings);
		
		#make available in plugins
		Configure::write('settings.ga_email', $this->settings['ga_email']);
		Configure::write('settings.ga_password', $this->settings['ga_password']);
		Configure::write('settings.ga_account', $this->settings['ga_account']);
		
		$pannels = array();
		if ($this->settings['ga_email'] && $this->settings['ga_password'] && $this->settings['ga_account'])	{
			$pannels['google_analytics'] = array('views', 'visits', 'keywords', 'referrers');		
		}
		
//		$pannels[]='system';
	//	$pannels['logs'] =   array('error', 'debug');
	//	debug($pannels);
		Configure::write('Status.panels',$pannels);
	}
 
	function isAuthorized(){
        if($this->Auth->user('group') == 'Administrator' or $this->Auth->user('group') == 'Super') return true; //Remove this line if you don't want admins to have access to everything by default
        if(!empty($this->permissions[$this->request->action])){
            if($this->permissions[$this->request->action] == '*') return true;
            if (!is_array($this->permissions[$this->request->action])) {echo "It must be an array of permissions" ; die;}
            if(in_array($this->Auth->user('group'), $this->permissions[$this->request->action])) return true;
        }
        return true;
    } 

}