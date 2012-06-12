
<article class="crumbs">
	<?php echo $this->element('tractor/nav/crumbs') ?>
</article>

<article class="login">
	<h1>Login</h1>
	
	
	<?php echo $this->Session->flash(); ?>
			
	
	<?php 
	echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'login')));
	echo $this->Form->input('email');
	echo $this->Form->input('password');
	//echo $this->Form->input('remember_me', array('label'=>'Remember Me', 'type'=>'checkbox'));
	
	echo $this->Form->submit('Login', array('class'=>'submit'));
	echo "<p class='dory'><a href='/users/reset'>Forgotten password</a></p>";
	
	
	
	echo $this->Form->end(); 
	?>

</article>