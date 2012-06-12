<?php
class MenuItem extends AppModel {

	
	var $validate = array(
		'title' => array('notempty'),
		'link' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'List' => array(
			'className' => 'menu',
			'foreignKey' => 'menu_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Content' =>array(
			'className' => 'Content',
			'foreignKey' => 'content_id',
		)
	);
	
	
	function afterSave(){
	
	}

}
?>