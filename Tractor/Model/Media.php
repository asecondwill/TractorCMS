<?php
class Media extends AppModel {

	
	var $validate = array(
		'filename' => array('notempty'),
		'type' => array('notempty'),
		'size' => array('notempty')
	);

}
?>