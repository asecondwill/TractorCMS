<section class="page clearfix">
	<?php echo $this->element('social'); ?>
	<div id="crumbs">
		<?php echo $this->element('tractor/nav/crumbs') ?>	
	</div>
		
	<aside>				
		<div class="events aside_item">
			
			<?php
				echo $this->Menu->setup($contents, array('selected' => $this->request->here, 'type' => 'context', 'menuClass' => 'context-menu'));
			 ?>
		</div>
		
		 <div class="aside_item more_info">
      <h2>More Information</h2>
      <ul>
         <li><a href='/send-to-friend'>Email to a friend</a></li>
        <li><a href='<?php echo $content['Content']['path'] ?>' title='<?php echo $content['Content']['title'] ?>' class='jQueryBookmark'>Bookmark this page</a></li>
       
      </ul>
    </div>	
		<?php //echo $this->element('Event/latest', array("number_of_events"=>3)); ?>		
		<?php echo $this->element('subscribe'); ?>

		</a>
	</aside>
		
	<article>
		<h1 class="eventcategory"><?php echo $content['CalendarCategory']['title'];?></h1>
		<?php echo $this->Layout->filter ($content['CalendarCategory']['body']);?>
		<?php //debug($this->request->params['url']['ext']); ?>
		<!-- EVENTS -->
		<?php 
			$i = 0 ;
			foreach($events as $event){
				$i = $i+1; 
				if ($i > 3 ) $i=1; 
				echo "
				<div class='event_box event_box_$i'><h2>{$event['CalendarEvent']['title']}</h2>";
					echo $this->element('Event/metrics', array('event'=>$event))	;
					
					echo "<p>" . nl2br($event['CalendarEvent']['excerpt'])  ."</p>";
					
					echo $this->Element('tractor/hero', array('heros' => $event['CalendarEvent']['hero']));
					echo "<br class='clear'/>";

					echo "<a href='{$event['Content']['path']}' class='more'>Find out more or book now</a></div>";
				
			}
		?>		
	</article>
</section>
