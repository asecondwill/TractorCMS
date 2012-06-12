<?php
foreach ($event_categories as $ec){
  echo "<li><a href='{$ec['Content']['path']}'>{$ec['Content']['title']}</a>";
  //echo $this->element('Eventcategories/context', $ec['children']);
  echo "</li>";
}