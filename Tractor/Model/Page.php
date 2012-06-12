<?php
class Page extends AppModel {

	
	//var $actsAs = array('Habtamable','Expandable', 'Sluggable' => array('separator' => '-', 'overwrite' => true));
	var $actsAs = array( 'Revision' ,  'Containable' , 'Tags.taggable'	);	

	var $validate = array(
    'title' => array(
        'rule'=>array('minLength', 1), 
        'message'=>'Title is required' )
	);
	
	var $hasOne = array(
		'Content' => array(
			'className' => 'Content',
			'conditions' => array('Content.class_name' => 'pages'),
			'foreignKey' => 'foreign_id', 
			'dependent' => true
		)
	);  
	
	var $hasAndBelongsToMany = array(
		
		'Featured' => array(
			'className' => 'Content',
			'joinTable' => 'content_featured',
			'foreignKey' => 'content_id',
			'associationForeignKey' => 'featured_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => 'ContentFeatured.id',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);	
			
}
?>