<?php

class InstallController extends Controller {
	public $uses = null;
	public $components = array('Session');

    public $defaultConfig = array(
        'name' => 'default',
        'datasource'=> 'Database/Mysql',
        'persistent'=> false,
        'host'=> 'localhost',
        'login'=> 'root',
        'password'=> '',
        'database'=> 'croogo',
        'schema'=> null,
        'prefix'=> null,
        'encoding' => 'UTF8',
        'port' => null,
    );
    protected function _check() {
//        if (file_exists(APP . 'Config' . DS . 'tractor_settings.php')) {
  //          $this->Session->setFlash('Already Installed');
    //        $this->redirect('/');
      //  }
    }
	
		
	public function index(){

	 	 $this->_check();
	 	 $this->set('title_for_layout', __('Installation: Welcome'));
	 	$this->layout = 'install';
	}
	
	 public function database() {
        $this->_check();
        $this->set('title_for_layout', __('Step 1: Database'));
		$this->layout = 'install';
		
        if (empty($this->data)) {
            return;
		}
		


        @App::import('Model', 'ConnectionManager');
        $config = $this->defaultConfig;
        foreach ($this->data['Install'] AS $key => $value) {
            if (isset($this->data['Install'][$key])) {
                $config[$key] = $value;
            }
        }

		
		try {
			@ConnectionManager::create('default', $config);
 		} catch (Exception $e) {	    	
	    	$this->Session->setFlash(__('Could not connect to database.'), 'default', array('class' => 'fail'));
            return;
		}
        

        $db = ConnectionManager::getDataSource('default');
        if (empty($db) || $db == null || !is_object($db) || !$db->isConnected()) { 
	        echo "oopsy";
            $this->Session->setFlash(__('Could not connect to database.'), 'default', array('class' => 'error'));
            return;
        }

        copy(TRACTOR.DS.'Config'.DS.'database.php.install', APP.'Config'.DS.'database.php');
        App::uses('File', 'Utility');
        $file = new File(APP . 'Config' . DS.'database.php', true);
        $content = $file->read();

        foreach ($config AS $configKey => $configValue) {
            $content = str_replace('{default_' . $configKey . '}', $configValue, $content);
        }

        if($file->write($content) ) {
        	 $this->Session->setFlash(__('Database Connection success.'), 'default', array('class' => 'success'));
            return $this->redirect(array('action' => 'data'));
        } else {
            $this->Session->setFlash(__('Could not write database.php file.'), 'default', array('class' => 'error'));
        }
    }
    public function data(){
    
	    $this->_check();        
		$this->layout = 'install';
		$this->set('title_for_layout', __('Step 2: Build database'));
		 
		if ($this->request->data){
		
		}
		
        if ($this->request->isPost()) {
            App::uses('File', 'Utility');
            App::import('Model', 'CakeSchema', false);
            App::import('Model', 'ConnectionManager');

            $db = ConnectionManager::getDataSource('default');
            if(!$db->isConnected()) {
                $this->Session->setFlash(__('Could not connect to database.'), 'default', array('class' => 'error'));
            } else {
            	# Create db from schema
                $schema =& new CakeSchema(array('name'=>'app'));
                $schema = $schema->load();
                foreach($schema->tables as $table => $fields) {
                    $create = $db->createSchema($schema, $table);
                    $db->execute($create);
                }
                
                # insert info from form
                
                App::uses('File', 'Utility');
		        $File =& new File(APP . 'Config' . DS . 'core.php');
		        if (!class_exists('Security')) {
		            require CAKE . 'Utility' .DS. 'Security.php';
		        }
		        $salt = Security::generateAuthKey();
		        $seed = mt_rand() . mt_rand();
		        $contents = $File->read();
		        $contents = preg_replace('/(?<=Configure::write\(\'Security.salt\', \')([^\' ]+)(?=\'\))/', $salt, $contents);
		        $contents = preg_replace('/(?<=Configure::write\(\'Security.cipherSeed\', \')(\d+)(?=\'\))/', $seed, $contents);
		        if (!$File->write($contents)) {
		            return false;
		        }
		
		        // set new password for admin, hashed according to new salt value
		         
		        $User = ClassRegistry::init('User');
		        $user = array('User'=>array(
		        	'password'	=>	Security::hash($this->request->data['Install']['password'], null, $salt), 
		        	'email'		=>	$this->request->data['Install']['email'],
		        	'first_name'		=>	$this->request->data['Install']['first_name'],
		        	'last_name'		=>	$this->request->data['Install']['last_name'],
		        	'confirmed'		=>	1
		        	));
		        $User->save($user); 
		        $this->log($user);
		        
		        $Setting = ClassRegistry::init('Setting');
		        $settings = array('Setting'=>array(
		        	'site' => 				$this->request->data['Install']['name'],
		        	'system_email_name' => 	$this->request->data['Install']['name'],
		        	'system_email' => 		$this->request->data['Install']['email'], 
		        	'theme'	=>				'tractor'
		        ));
				$Setting->save($settings);
                $this->log($settings);

                $this->redirect(array('action' => 'finish'));
            }
        }
    }
    
    public function finish(){
    	 $this->set('title_for_layout', __('Installation completed successfully'));
	      
        $this->_check();

        // set new salt and seed value
        copy(TRACTOR.DS.'Config'.DS.'tractor_settings.php.install', APP.'Config'.DS.'tractor_settings.php');
        
       
    	//}
    }
    
	

}