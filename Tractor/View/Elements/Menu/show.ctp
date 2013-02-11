<?php 
	
	 $this->loadHelpers(array('MTree'));
	
	
	$menu =	$this->requestAction(array('plugin'=>false,'controller' => 'menus', 'action' => 'view'), array('pass'=> array($name)));
	
	
	
	$attribs="";

	if (!empty($id)) $attribs .= "id = $id ";
	if (!empty($class)) $attribs .= "class = $class ";
	
	if (empty($level)) $level = 0;
	if (empty($li)) $li = false;

	echo $this->MTree->sitemap( $menu,  array('attributes'=>$attribs, 'level'=>$level, 'li'=>$li, 'after'=>$after)); 
	
//	echo $this->Html->link('/home');
