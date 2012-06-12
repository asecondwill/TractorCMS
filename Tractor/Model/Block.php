<?php
class Block extends AppModel {
	var $name = 'Block';
	var $displayField = 'title';
	var $validate = array();
	
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
        'Region' => array(
            'className' => 'Region',
            'foreignKey' => 'region_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true,

        ),
    );
}
?>