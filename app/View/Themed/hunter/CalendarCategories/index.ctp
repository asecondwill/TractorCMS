<section class="page clearfix">
	<?php echo $this->element('social'); ?>
	<div id="crumbs">
		<?php echo $this->element('tractor/nav/crumbs') ?>	
	</div>
		
	<aside>				
		<div class="events aside_item">
			

			<ul class="context-menu">
			<li><a href='<? echo $this->here ; ?>'>Events</a>
			<?php
//				debug($event_categories);
				
				
				//echo $this->element('Eventcategories/context', $event_categories);
				
				echo $this->mTree->context($event_categories);
				
				//echo $menu->setup($event_categories, array('selected' => $this->here, 'type' => 'context', 'menuClass' => 'context-menu'));
			 ?>
			 </li>
			 </ul>
			 <br/>
			 <ul class="context-menu"><li><ul><li><a href='events/'>View All Events by date</a></li></ul></li></ul>
		</div>
		
				<?php echo $this->element('Event/latest', array("number_of_events"=>3)); ?>		
		<?php echo $this->element('subscribe'); ?>
		</a>
	</aside>
		
	<article>
		<h1 class='eventcategories'>Events</h1>
		
		<?
			$i = 0 ;
			foreach($categories as $cate){
				$i = $i+1; 
				if ($i > 3 ) $i=1; 
				echo "
				<div class='event_box event_box_$i'>
					<h2><a href='{$cate['Content']['path']}'>{$cate['Content']['title']}</a></h2>
					<p>" . nl2br($cate['CalendarCategory']['excerpt']) ."</p>";
					echo $this->Element('tractor/hero', array('heros' => $cate['CalendarCategory']['hero']));	
					echo "<br class='clear'/>
					<a href='{$cate['Content']['path']}' class='more'>Tell me more</a>
				</div>
				";
					
					
			}
		?>
		<!-- EVENTS -->
		
	</article>
</section>
