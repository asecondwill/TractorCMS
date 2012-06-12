<section class="page clearfix">
	<?php echo $this->element('social'); ?>
	<div id="crumbs">
		<?php echo $this->element('tractor/nav/crumbs') ?>	
	</div>
		
	<aside>
		
		
		
		<?php echo $this->element('Event/latest', array("number_of_events"=>3)); ?>		
		<?php echo $this->element('subscribe'); ?>

		</a>
	</aside>
		
	<article>
		<h1><?php echo $content['Page']['title'];?></h1>
		<?php echo $content['Page']['body'];?>
		
		<div class='subscribe'>
			
				<form action="http://frecklecreativepartners.createsend.com/t/y/s/bjttit/" method="post" id="subForm">
				
				<input type="text" name="cm-name" id="name" /><br />
				<input type="text" name="cm-bjttit-bjttit" id="bjttit-bjttit" /><br />
				
				<input id='button' type="submit" value="Subscribe"/>
				
				</form>
			
		</div>
	</article>
</section>
