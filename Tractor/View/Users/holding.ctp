<div id="outpage">

<h1>
<img src="/img/hay_nice_to_meet_you.jpg" alt="hay_nice_to_meet_you" width="376" height="49" />
</h1>
<p>
	We're busy preparing a warm welcome but it's not quite ready yet! Please enter your details so we can send you an invitation as soon as we are ready to take your volunteer registration.
Then you can join our volunteers, who do it in some of the most beautiful sites imaginable. In the dunes, the bush and by the river; by planting, organising and using statistics - among other skills. With Landcare Week just around the corner, now's the time to make a difference.
</p>
<?php if($content['Content']['strap'] !='') echo '<p class="strap">' . $content['Content']['strap'] . '</p>' ?>
<?php echo $content['Content']['body'] ?>
<?php echo $this->Session->flash(); ?>

<div class="form">
<h2>Your Details</h2>
<?php echo $this->Form->create('User', array('action'=>'holding', 'class'=>'niceform'));?>
	
	<?php
		echo $this->Form->input('username', array('label'=>'Name. *'));
		echo $this->Form->input('email', array('label'=>'Email Address. *'));
		echo $this->Form->input('phone', array('label'=>'Phone.'));
		echo $this->Form->input('yob',array('label'=>'Y.O.B.'));
		echo $this->Form->input('postcode', array('label'=>'Postcode.'));

		
	?>
	<?php echo $this->Form->submit('go.gif', array('class'=> 'image_input'));?>
<?php echo $this->Form->end();?>
</div>
</div>


<br class="clear"/>