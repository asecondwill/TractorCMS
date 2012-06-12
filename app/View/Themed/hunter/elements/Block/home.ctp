<?php

$blocks = $this->requestAction(array('controller' => 'blocks', 'action' => 'region'), array('pass' =>  array( 'homepage')));


echo "<div id='slider'><ul >";
foreach ($blocks as $block){
		echo  "<li>{$block['Block']['body']}</li>";
}
echo "</ul></div>";
