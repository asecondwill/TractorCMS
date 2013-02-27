<section class="page clearfix">
<p class="social">
		<a href="http://www.facebook.com/pages/Hunter-Valley-Wine-Industry-Association/75509093611"><?php echo $this->Html->image("facebook.png",  array('alt'=>"Become a fan on Facebook"));?></a> 
		<a href="http://twitter.com/_hunterwine"><?php echo $this->Html->image("twitter.png" , array('alt'=>"Follow us on Twitter",  'border'=>"0"));?></a>
	</p>
<div id="crumbs">
	<?php echo $this->element('tractor/nav/crumbs') ?>
</div>

<article class="login">

<h1>Password Reset</h1>

<?php echo $this->Session->flash(); ?>

	<?php 
echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'reset')));
echo $this->Form->input('email');
echo $this->Form->submit('Reset', array('class'=>'button')); 

echo $this->Form->end(); 
?>
</article>
</section>