<div id="outpage">

<h1><?php echo $content['Content']['header'] ?></h1>
<?php if($content['Content']['strap'] !='') echo '<p class="strap">' . $content['Content']['strap'] . '</p>' ?>
<?php echo $content['Content']['body'] ?>
<?php echo $this->Session->flash(); ?>

<div class="form">
<?php echo $this->Form->create('User', array('action'=>'register'));?>
	
	<?php
		echo $this->Form->input('username', array('label'=>'Username'));
		echo $this->Form->input('email');
		echo $this->Form->input('passwd', array('label'=>'Password', 'autocomplete'=>'off'));
		
	?>
	<?php echo $this->Form->submit('Register', array('class'=>'button')); ?>
<?php echo $this->Form->end();?>
</div>
</div>


<?php echo $this->element('sub',array('content'=>$content)); ?>	

<br class="clear"/>