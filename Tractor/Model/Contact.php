<?php
class Contact extends AppModel {

	public $name = 'Contact';

	
	public $actsAs = array( 'Revision' ,   'Containable','Tags.Taggable'	);	

	public $validate = array(
    'title' => array(
        'rule'=>array('minLength', 1), 
        'message'=>'Title is required' )
	);
	
	public $hasOne = array(
		'Content' => array(
			'className' => 'Content',
			'conditions' => array('Content.class_name' => 'contacts'),
			'foreignKey' => 'foreign_id', 
			'dependent' => true
		)
	);  
	
	public $hasMany = array(
		'Message' => array(
			'className' => 'Message',			
			'foreignKey' => 'contact_id', 
			
		)
	);  		
}
?>