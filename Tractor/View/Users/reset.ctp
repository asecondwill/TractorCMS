<article class="crumbs">
	<?php echo $this->element('tractor/nav/crumbs') ?>
</article>

<article class="reset">

<h1>Password Reset</h1>

<?php echo $this->Session->flash(); ?>

	<?php 
echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'reset')));
echo $this->Form->input('email');
echo $this->Form->submit('Reset', array('class'=>'button')); 

echo $this->Form->end(); 
?>
</article>