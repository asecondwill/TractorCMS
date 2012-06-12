<article>
	<?php echo $this->element('tractor/nav/crumbs') ?>	
</article>

<article>
	<h1><?php echo $contact['Contact']['title']?></h1>  
	<?php echo $contact['Contact']['body']?>
	
	<?php
	echo $this->Session->flash();
		echo $this->Form->create('Message', array('url'=>$contact['Content']['path']));
		echo $this->Form->input('Message.contact_id', array('type'=>'hidden', 'value'=>$contact['Contact']['id']));
		echo $this->Form->input('Message.email');
		echo $this->Form->input('Message.details', array('label'=>'Message', 'cols'=>100));
		echo $this->Form->end("Send Message");
	?>
</article>