<?php 
class Group extends AppModel {
    var $name = 'Group';
    var $displayField = 'name';

    var $hasMany = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'group_id',
            'dependent' => false
        )
    );

}
?>