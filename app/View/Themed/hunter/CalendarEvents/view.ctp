<section class="page clearfix">
  <?php echo $this->element('social'); ?>
  
  <div id="crumbs">
    <?php echo $this->element('tractor/nav/crumbs') ?>  
  </div>
    
  <aside>        
    <div class="events aside_item">
      
      <?php
        echo $this->Menu->setup($contents, array('selected' => $this->here, 'type' => 'context', 'menuClass' => 'context-menu'));
       ?>
    </div>
    
    <div class="aside_item more_info">
      <h2>More Information</h2>
      <ul>
        <?php if (!empty($content['CalendarEvent']['ics'])) {
          $heros = explode(",", $content['CalendarEvent']['ics']);
      foreach($heros as $key => $item)
      {
         if(trim($item) == "")
         {
             unset($heros[$key]); //Remove from teh array.
         }
      }      
      $heros_str = implode($heros);
      $heros = explode(",", $heros_str);
      echo "<li><a href='/media/{$heros[0]}";
           echo "'>Add this event to your calendar</a></li>" ; 
    }
    ?>
        <li><a href='/send-to-friend'>Email to a friend</a></li>
        <li><a href='<?php echo $content['Content']['path'] ?>' title='<?php echo $content['Content']['title'] ?>' class='jQueryBookmark'>Bookmark this page</a></li>
       
     <!--   <a href="javascript:bookmark('', '<?php echo $content['Content']['title'] ?> ');" >Bookmark this page</a> -->
      </ul>
    </div>

    <?php  echo $this->element('Event/latest', array("number_of_events"=>4)); ?>    
    
    <?php echo $this->element('subscribe'); ?>
  </aside>
    
  <article>
    <h1 class="event"><?php echo $content['CalendarEvent']['title'];?></h1>
    <h2><?php echo $content['CalendarEvent']['strap'];?></h2>
  <?php    echo $this->Session->flash(); ?>
    <? echo $this->element('Event/metrics', array('event'=>$content))  ; ?>
    <br/><? echo $content['CalendarEvent']['body'] ?>
  </article>

</section>