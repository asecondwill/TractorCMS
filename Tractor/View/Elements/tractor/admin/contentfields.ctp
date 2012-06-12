<?php
	echo $this->Form->input('Content.id');
	echo $this->Form->input('Content.slug', array('label'=>'Link'));
	echo $this->Form->input('Content.title', array('label'=>'Link Title'));		
	echo $this->Form->input('Content.keywords');
	echo $this->Form->input('Content.description');
	echo $this->Form->input('Content.meta_tags');
	
	echo $this->Form->input('Content.action', array('type'=>'hidden', 'value'=>'view'));
?>



