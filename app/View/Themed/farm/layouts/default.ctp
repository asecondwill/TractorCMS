<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <?php echo $html->charset(); ?>
  <title>
    <?php echo $title_for_layout; ?>
  </title>
  
  <?php
//  echo $this->Html->css('text');
  
  $this->AssetCompress->css('reset','farm');  
  $this->AssetCompress->css('text','farm');
  $this->AssetCompress->css('960','farm');
  $this->AssetCompress->css('site','farm');

  $this->AssetCompress->css('debug','farm');

  
  echo $this->AssetCompress->includeAssets(true);
?>
</head>
<body>
	<div class="container_12 clearfix">
	  <div class='alpha grid_6'><h1>Tractor</h1></div>
	  <div class='omega grid_6'><h4>Content Management<h4></div>
	</div>    
	<div class="container_12">
		<div class="grid_12 alpha">
			<?php	echo $menu->setup($contents, array('type'=> 'tree', 'modelName'=>'Content', 'title'=>'title', 'depth' =>1, 'slugUrl' =>'path',  'selected' => $this->here)); 
			?>
			
		</div>
	</div>
	
	<?php echo $content_for_layout ?>

  
</body>