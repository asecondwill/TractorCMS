<div id="outpage" class='user'>
<h1><?php echo $content['Content']['header'] ?></h1>
<?php if($content['Content']['strap'] !='') echo '<p class="strap">' . $content['Content']['strap'] . '</p>' ?>
<?php echo $content['Content']['body'] ?>
<?php echo $this->Session->flash(); ?>

<?php echo $this->Form->create('User');?>
<div class="form">
	<h2>User Details</h2>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('username');
		echo $this->Form->input('city');
		echo $this->Form->input('country');
		
		echo $this->Form->input('contactable', array('div'=>'contacty', 'label'=>'Give logged-in members ability to contact me through a contact form.'));
		echo $this->Form->input('subscribe', array('label'=>'Receive Newsletter'));
	?>	
</div>
<div class="form">
	<h2>About You</h2>
	<?php
		
		echo $this->Form->input('employment', array('cols'=>50, 'rows'=>3, 'label'=>'Employer / Organisation'));
		echo $this->Form->input('about', array('cols'=>50));
		echo $this->Form->input('quote', array('cols'=>50,  'rows'=>3));
		
	?>
	
	</div>
	
	<div class="form">
		<?php echo $this->Form->submit('Save Changes'); ?>
	</div>
	
			

<?php echo $this->Form->end();?>


<br/>
</div>
<?php echo $this->element('sub',array('content'=>$content)); ?>	

<br class="clear"/>