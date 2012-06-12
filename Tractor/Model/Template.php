<?php
class Template extends AppModel {

	var $name = 'Template';
	var $validate = array(
		'name' => array('notempty')
	);

	

}
?>