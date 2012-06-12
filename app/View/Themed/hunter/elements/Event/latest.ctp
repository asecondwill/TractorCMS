<div class="events_feed aside_item">
			<h2>Upcoming Hunter Valley Events</h2>

<?php
$events = Cache::read("events_$number_of_events");
if ($events == false){
	$events =	$this->requestAction(array('plugin'=> 'calendar' ,'controller' => 'calendar_events', 'action' => 'latest'), array('pass' => array(  $number_of_events , 'asc' )	));
}


if ($events){
	
	foreach($events as $event){
		echo "<h3><a href='{$event['Content']['path']}'>{$event['Content']['title']}</a></h3>
			" . $this->Time->format('l d M Y', $event['CalendarEvent']['eventstart']) . "
			<a class='more' href='{$event['Content']['path']}'>Read More</a><br/>
		";		
	}
	
}

?>			
		
		</div>