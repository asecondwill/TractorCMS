	<div id="Banner">
	<?php //echo $this->Html->image('Get-Hands-On.png', array('alt' => 'Get hands on with great Hunter Valley wines - Friday 7th Oct Ð Sunday 6th Nov 2011 - Coming soon',  "title" => 'Get hands on with great Hunter Valley wines - Friday 7th Oct Ð Sunday 6th Nov 2011 - Coming soon')); ?>
	
	<?php echo $this->element('Block/home'); ?>
	
	</div>

<section class="home">
<div class="intro">
	<?php echo $content['Page']['body'];?>
</div>


	<?php
		$i = 0;
		foreach ($content['Featured'] as $feat){
			if (!empty($feat['Event'])) {
				$feat['Detail'] = $feat['Event'];
			}else{
				$feat['Detail'] = $feat['Eventcategory'];	
			}	
			$i = $i +1;
			echo "<div class='content_box Content-Box$i alpha'>";
			echo	$this->Element('tractor/hero', array('heros' => $feat['Detail']['hero']));
		    echo 	"<div class='content-text-box'><h2><img src='/theme/hunter/img/hunter.gif' alt ='hunter Valley'/></h2>";
	    	echo 	"<h3>{$feat['Detail']['title']}</h3>";
	      	echo 	"<span class='Content-text'>";
	      	
	      	if  (!empty($feat['Detail']['where']))echo $feat['Detail']['where'];
	      	if  (!empty($feat['Detail']['location']))echo $this->Text->truncate($feat['Detail']['location'], 38, array('exact'=>false, 'ending'=>''));
	      	
	      	echo "<br/>";
	      	
	      	if  (!empty($feat['Detail']['eventstart'])) echo $this->element('Event/daterange', array('event' => $feat));
	      	if  (!empty($feat['Detail']['when']))echo $feat['Detail']['when'];

	      	echo 	"<a class='more' href='{$feat['path']}'>Tell Me More</a></span><br />"; 
	   	 	echo 	"</div>";	
			echo "</div>";
		}
	?>
</section>	



<div id="social">
		<div id='newsletter'>
			<div class="sell">
				<h2>Sign up to our eNewsletter</h2>
				<p>Sign up and we'll keep you uptodated with monthly emails on special offers show updates and more</p>
			</div>	
			<div class="do">
				<script>
					
				</script>
				<form action="http://frecklecreativepartners.createsend.com/t/y/s/bjttit/" method="post" id="subForm">
				<div>
				<input type="text" name="cm-name" id="name" /><br />
				<input type="text" name="cm-bjttit-bjttit" id="bjttit-bjttit" /><br />
				
				<input id='subscribe' type="image" src="/theme/hunter/img/subscribe.png"/>
				</div>
				</form>
			</div>	
		</div>
		
		
		<div id="facebook">
			<a target="_blank" href="http://www.facebook.com/pages/Hunter-Valley-Wine-Industry-Association/75509093611"><?php echo $this->Html->image("facebook_big.jpg",  array('alt'=>"Become a fan on Facebook"));?></a> 
			<span><a href="http://www.facebook.com/pages/Hunter-Valley-Wine-Industry-Association/75509093611"><strong>Become a fan</strong><br/> on Facebook</a></span>
		</div>
		
		<div id="twitter">
			<a href="http://twitter.com/_hunterwine"><?php echo $this->Html->image("twitter_big.jpg" , array('alt'=>"Follow us on Twitter",  'border'=>"0"));?></a>
			<span><a href="http://twitter.com/_hunterwine"><strong>Follow us</strong><br/> on Twitter</a></span>
		</div>
	</div>


