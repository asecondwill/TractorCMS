<?php
 if ($event['Event']['eventstart'] != $event['Event']['eventend']) {
    echo $this->Time->format('l d M Y', $event['Event']['eventstart'])  . " - " . $this->Time->format('l d M Y', $event['Event']['eventend']) ;
  }else{
    echo $this->Time->format('l d M Y', $event['Event']['eventstart']);
  }   