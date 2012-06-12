


<?php
$i = 0;
foreach ($medias as $media):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	
			<?php 
			
			if ($media['Media']['type']=='gif' or $media['Media']['type']=='png' or $media['Media']['type']=='jpg'){
			
			echo "<a href='#'  id='" .  $media['Media']['filename'] . "' class='media-item-$field_name'>";
			 echo   $image->resize("/../media/" . $media['Media']['filename'] , 80, 80, true,array('border'=>'0', 'title' => $media['Media']['filename'], 'alt'=>'MyImage'));
			 echo "</a>";
			}
			else{
				echo "<a href='#' id='" .  $media['Media']['filename'] . "' class='media-item'><span> " . $media['Media']['filename'] . '</span></a>';
			}
			?>
<?php endforeach; ?>
