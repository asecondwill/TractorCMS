<?php 
echo "<table class='event_metrics'>";
if (!empty($event['Event']['eventstart'])) {
  echo "<tr><th>When</th><td>";
 echo $this->element('Event/daterange',array('event'=> $event));
  echo "</td></tr>";
}  
if (!empty($event['Event']['timeofday'])) echo "<tr><th>Time</th><td>{$event['Event']['timeofday']}</td></tr>";
if (!empty($event['Event']['location'])) echo "<tr><th>Where</th><td>{$event['Event']['location']}</td></tr>";
if (!empty($event['Event']['map'])) echo "<tr><th>Map</th><td><a href='http://maps.google.com/?q={$event['Event']['map']}' target='_blank'>View Map</td></tr>";
if (!empty($event['Event']['cost'])) echo "<tr><th>Cost</th><td>{$event['Event']['cost']}</td></tr>";

if (!empty($event['Event']['bookings'])) echo "<tr><th>Booking</th><td>{$event['Event']['bookings']}</td></tr>";
 
if (!empty($event['Event']['website'])) echo "<tr><th>Website</th><td>{$this->Text->autoLink($event['Event']['website'], array('target'=>'_blank'))}</td></tr>";

echo "</table>"  ;
        
                
        