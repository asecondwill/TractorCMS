<div id='content' class="container_12">
<div id='users' class="grid_8">


<h1><?php echo $content['Content']['header'] ?></h1>
<?php if($content['Content']['strap'] !='') echo '<p class="strap">' . $content['Content']['strap'] . '</p>' ?>
<?php echo $content['Content']['body'] ?>
<?php echo $this->Session->flash(); ?>

<div class="form">
<?php echo $this->Form->create('User', array('action'=>'change'));?>
	
	<?php
		
		echo $this->Form->input('passwd', array('label'=>'Password', 'autocomplete'=>'off'));
		
	?>
	<?php echo $this->Form->submit('Change Password', array('class'=>'button')); ?>
<?php echo $this->Form->end();?>
</div>
</div>
<div class='sub'>		
<?php echo $content['Content']['sub'] ?>
<? 
if($content['RelatedPages']){
	echo "<div class='related'><h1>" . $content['Content']['related_title'] . "<span class='frill_sub'>//</span></h1><ul>";
	foreach($related_pages as $page){
		
		echo "<li><a href='/pages/" . $page['Content']['slug'] . "'>" . $page['Content']['header'] . "</a></li>";
	}
	echo "</ul></div>";	
}
?>
</div>

<br class="clear" /><br class="clear" />