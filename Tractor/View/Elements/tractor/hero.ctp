<?php

$heros = explode(",", $heros);

foreach($heros as $key => $item)
{
   if(trim($item) == "")
   {
       unset($heros[$key]); //Remove from teh array.
   }
}
$heros_str = implode($heros);
$heros = explode(",", $heros_str);

if (!empty($heros[0] ))echo "<img class='thumb' src='/media/".  $heros[0] . "'/>";