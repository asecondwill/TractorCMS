<div id="outpage" class='user'>

<h1><?php echo $user['User']['username']; ?>'s Profile
<div class="actions">
<?php 
if($current_user['User']['id'] == $user['User']['id']){
	echo $this->Html->link(__('Edit Profile'), array('controller' => 'users', 'action' => 'edit', $user['User']['id'])); 
	echo $this->Html->link(__('Change Password'), array('controller' => 'users', 'action' => 'change', $user['User']['id'])); 
}	
?> 
</div>
</h1>

	<?php echo $this->Session->flash(); ?>
<!-- <div class='when'>Last Updated vvv <?php echo $this->Time->format('d F Y',$user['User']['modified']); ?>	</div> -->
		
<h2>About</h2>		
<h3>Employer/Organisation:</h3>
<?php echo $user['User']['employment']; ?>

<p>
<?php echo $user['User']['about']; ?>
</p>
<p class="quote">
<?php echo $user['User']['quote']; ?>
</p>

<h2>Links</h2>
<?php 
//foreach($user['Lin'])
?>
<h3>Add a Link</h3>
<table class="links">
<?php
	foreach($user['Link'] as $link){
		echo "<tr><td><a href='";
		if (substr(strtolower( $link['url'] ), 0, 7) != 'http://'){
			echo "http://";
		}
		echo   $link['url'] . "'>" . $link['url'] . "</a></td>";
		if($current_user['User']['id'] == $user['User']['id']){
			echo "<td><a class='subtle_button' href='/users/link_delete/" . $link['id'] . "'>Delete</a></td>";  
		}
		
		echo "</tr>";
	}
?>
</table>
<?php if($current_user['User']['id'] == $user['User']['id']){ ?>
<div class="inline_form">
<?php 
	echo $this->Form->create('User', array('url'=>'/users/view/' . $user['User']['id'] ));
	echo $this->Form->input('Link.url');
	echo $this->Form->submit('Save Link'); 
	echo $this->Form->end();
?>
</div>
<?php }?>
</div>
<?php if ($user['User']['contactable'] == 1){?>
<div class='sub'>	
<div class="quick_contact">
	<h1>Quick Contact <span class="frill_sub">//</span></h1>
	<div>
	<?php
		echo $this->Form->create('Contact', array('url'=>'/users/view/' . $user['User']['id'] ));
		
		echo $this->Form->input('name', array('size'=>'26', 'label' => 'Your Name'));
		
		
		echo $this->Form->input('email', array('size'=>'26', 'label' => 'Your Email'));
		
		
		echo $this->Form->input('message', array('cols'=>'31', 'rows'=>'5', 'label'=>'Comment'));
		echo $this->Form->end('Send Email') ;
	 ?>	
	 </div>	
</div>
<?php }

?>
</div>
<br class="clear" />
