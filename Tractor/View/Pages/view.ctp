<?php
$a = "
$(document).ready(function() {
 
	//ACCORDION BUTTON ACTION	
	$('.accordionButton').click(function() {
		$('.accordionContent').slideUp('normal');	
		$(this).next().slideDown('normal');
	});
 
	//HIDE THE DIVS ON PAGE LOAD	
	$(\".accordionContent\").hide();
	
	$(\".open\").trigger('click');
 
});
";
$this->Js->buffer($a); 
echo $this->Html->css(array('accordian'));
?>

<div class="info">


<?php echo $this->element('mailchimp'); ?>
</div><!-- .info -->
			
<div class="main contact">
	<div class="crumbs">
		<a href='/'>Home</a> > <?php echo $content['Page']['title']?>
	</div><!-- .crumbs -->
				<h1><?php echo $content['Page']['title']?></h1>	
				<?php echo $content['Page']['body']?>




</div><!-- .main -->

<div class="context contact">

	<?php
		if ($content['Page']['hero']){
			echo "<br/><img src='/media/{$content['Page']['hero']}'/>";		
		}
	
	?>
	



</div>		
	