<?php
class Content extends AppModel {	
	var $actsAs = array('Containable', 'Tree', 'SluggableTree' => array('separator' => '-', 'overwrite' => false));
	
	function afterSave(){
		Cache::delete('contents'); 				   
		$contents  = $this->find('all');
		Cache::write('contents', $contents);
		
		# TODO: move this to the tree slug behaviour, 
		# so it only has to do it for relevent child content, not the whole site.
		
		foreach ($contents as $c){
			$path = $this->getPath($c['Content']['id'], array('Content.id')); 
			$path_count  = count($path);
			$this->query("update contents set depth = {$path_count} where id  = {$c['Content']['id']}") ;
		}	
		
		
	}
		
	var $belongsTo = array(
			/*
				'CalendarEvent'=>array(
					'className'		=>	'Calendar.CalendarEvent',
					'foreignKey'    => 'foreign_id'
				),				
				'CalendarCategory'=>array(
					'className'		=>	'Calendar.CalendarCategory',
					'foreignKey'    => 'foreign_id'
				),
			*/	
				'ParentContent' => array(
		            'className' => 'Content',
		            'foreignKey' => 'parent_id',
		            'conditions' => '',
		            'fields' => '',
		            'order' => ''
        		)						
			);	
	}