<table class="pick_from">
	<?php
		
		foreach($content_tree as $content){
			echo "<tr><td>" .
				 	str_repeat('-', $content['Content']['depth']) .  
					 $content['Content']['title'] . 
				"</td><td>";
				if ($class_name == 'all' or $class_name == $content['Content']['class_name'])	echo "<a class='action' OnClick=\"additem(" . $content['Content']['id'] . ",'" .  str_replace("'", "\'",  $content['Content']['title']) . "');\" >+</a>";
				echo "</td></tr>";
		}
	?>
</table>