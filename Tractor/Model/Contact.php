<?php
class Contact extends AppModel {

	var $name = 'Contact';

	
	var $actsAs = array( 'Revision' ,   'Containable','Tags.Taggable'	);	

	var $validate = array(
    'title' => array(
        'rule'=>array('minLength', 1), 
        'message'=>'Title is required' )
	);
	
	var $hasOne = array(
		'Content' => array(
			'className' => 'Content',
			'conditions' => array('Content.class_name' => 'contacts'),
			'foreignKey' => 'foreign_id', 
			'dependent' => true
		)
	);  
	
	var $hasMany = array(
		'Message' => array(
			'className' => 'Message',			
			'foreignKey' => 'contact_id', 
			
		)
	);  		
}
?>