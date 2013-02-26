<?php 
App::uses('AuthComponent', 'Controller/Component');
class User extends AppModel {
    var $name = 'User';
    var $actsAs = array('Multivalidatable', 'Containable'); 	
	var $validate = array(
		'username' => array(
		 'required' => true
            /*
            'unique' =>array(
            	'rule'=> 'validateUniqueName', 
            	'message' => 'This Username is already in use, please try another.'
            	),    
            'between' => array(
                'rule' => array('between', 5, 15),
                'message' => 'Between 5 to 15 characters'
            )*/
        ),
        'passwd' => array(
            'rule' => array('minLength', '6'),
            'message' => 'Mimimum 6 characters long'
        ),
        'email' => array(
            'emailaddress' => array(
                'rule' => 'email',
                'required' => true,
                'message' => 'Check you have entered your Email correctly.'
                ),
            'unique' =>array(
            	'rule'=> 'validateUniqueEmail', 
            	'message' => 'This Email is already in use, please try another. If you have already registered, but can\'t log in; try the password reset'
				 
            	)
        )
);

    var $displayField = 'username';
    
     var $validationSets = array(
     	'none' => array(),
        'basic' => array(
                
                'email' => array('rule' => 'email')
                
        ),
        'holding' => array(
                
                'email' => array(
					            'emailaddress' => array(
					                'rule' => 'email',
					                'required' => true,
					                'message' => 'Check you have entered your email correctly.'
					                ),
					            'unique' =>array(
					            	'rule'=> 'validateUniqueEmail', 
									 'message' => 'You have already registered your interest.'
					            	)
					        ),
               
                'username' => array(
					            'notEmpty' => array(
					                'rule' => 'notEmpty',
					                'required' => true,
					                'message' => 'Check you have entered your Name correctly.'
					                )
					        ),
				 'conditions' => array(
					            'one' => array(
					                'rule' => array('equalTo', '1'),  					               
					                'message' => 'Check you have agreed to the terms.'
					                )
					        )            	                        
        ),
        
        
           
       

        'password' => array(
            'passwd' => array(
            'rule' => array('minLength', '6'),
            'message' => 'Mimimum 6 characters long'
        	)
        )
        
        );


    
    
    var $belongsTo = array(
        'Group' => array(
            'className' => 'Group',
            'foreignKey' => 'group_id'
        )    
    );
    
     

	
	 function unique($data, $name){
		  $this->recursive = -1;
		  $found = $this->find(array("{$this->name}.$name" => $data));
		  $same = isset($this->id) && $found[$this->name][$this->primaryKey] == $this->id;
		  return !$found || $found && $same;
	 }
 
 
    function beforeSave()  
    {  
	
     $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);   
     parent::beforeSave();
     return true;  
   	}  

	function validateUniqueEmail(){

		$error=0;
		$someone = $this->findByEmail($this->data['User']['email']);
		if (isset($someone['User']))
		{
			$error++;

		}
		return $error==0;
	}

	function validateUniqueName(){

		$error=0;
		$someone = $this->findByUsername($this->data['User']['username']);
		if (isset($someone['User']))
		{
		$error++;		
		}
		return $error==0;
	}

}
?>