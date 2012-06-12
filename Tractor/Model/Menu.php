<?php 
class Menu extends AppModel {

    var $actsAs = array('Multivalidatable'); 	
	/*
	var $validate = array(
		'name' => array(
            'unique' =>array(
            	'rule'=> 'unique', 
            	'message' => 'This Menu is already in use, please try another.'
            	)
        
            )
        );
*/
	
	var $hasMany = array(
		'MenuItem' => array(
			'className' => 'MenuItem',
			'foreignKey' => 'menu_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
		
	);

	 function unique($data, $name){
		  $this->recursive = -1;
		  $found = $this->find(array("{$this->name}.$name" => $data));
		  $same = isset($this->id) && $found[$this->name][$this->primaryKey] == $this->id;
		  return !$found || $found && $same;
	 }

	function validateUniqueName(){
	// this returns false posotive when updating - it finds itself
		$error=0;
		$someone = $this->findByName($this->data['Menu']['name']);
		if (isset($someone['Menu']))
		{
		$error++;		
		}
		return $error==0;
	}

}
?>