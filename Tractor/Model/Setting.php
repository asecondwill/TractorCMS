<?php
class Setting extends AppModel {
	//var $name = 'Setting';
	public $validate = array(
		'site' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'You must fill this field in.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'keywords' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'You must fill this field in.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'description' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'You must fill this field in.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'system_email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Please enter a valid email address',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'system_email_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'You must fill this field in.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'offline' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	
	public function afterSave($created) {	 	       		
//		    Cache::write('Settings', $this->data['Setting']);    
		    
//			App::import('Model', 'CakeSession');
//			$session = new CakeSession(); 
				
//		    $session->write('debug_override_ips',   $this->data['Setting']['debug_override_ips']);			    
	 }
}
