<section class="page clearfix">
	<?php echo $this->element('social'); ?>
	<div id="crumbs">
		<?php echo $this->element('tractor/nav/crumbs') ?>	
	</div>
		
	<aside>				
		<div class="events aside_item">
			

			<ul class="context-menu">
			<li><a href='<? echo $this->request->here ; ?>'>Events</a>
			<?php
//				debug($event_categories);
				
				
				//echo $this->element('Eventcategories/context', $event_categories);
				
				echo $this->mTree->context($event_categories);
				
				//echo $this->Menu->setup($event_categories, array('selected' => $this->request->here, 'type' => 'context', 'menuClass' => 'context-menu'));
			 ?>
			 </li>
			 </ul>
			
			
		</div>
		
				<?php echo $this->element('Event/latest', array("number_of_events"=>3)); ?>		
		<?php echo $this->element('subscribe'); ?>
		</a>
	</aside>
		
	<article>
		<h1 class="events">Events</h1>
		<table id='events'>
		<tr><th>Event</th><th>When</th><th>Experience</th></tr>
		<?
			$i = 0 ;
			foreach($events as $event){
				$i = $i+1; 
				if ($i > 3 ) $i=1; 
				echo "
				<tr>
					<td>
						<a href='{$event['Content']['path']}'>{$event['Content']['title']}</a>
					</td>
					<td>". 
						$this->element('Event/daterange', array('event'=>$event)) . 
					"</td>
					<td>
						{$event['Eventcategory']['Eventcategory']['title']}
					</td>
				</tr>";					
			}
		?>
		</table>
		<!-- EVENTS -->
		
	</article>
</section>
