<div class='container_12'>
  <div class="grid_3 alpha">
  <?php	echo $menu->setup($contents, array('type'=>'context', 'modelName'=>'Content', 'title'=>'title', 'depth' =>1, 'slugUrl' =>'path',  'selected' => $this->here)); 
		?>
    <?php echo $this->element('mailchimp'); ?>
    
  </div><!-- .info -->
      
  <div class="grid_6">
    <?php echo $this->element('tractor/nav/crumbs') ?>

    <h1><?php echo $page['Page']['title']?></h1>  
    <?php echo $page['Page']['body']?>

  </div>

  <div class="omega grid_3">

  <?php
    if ($page['Page']['hero']){
      echo "<br/><img src='/media/{$page['Page']['hero']}'/>";    
    }
  
  ?>
  </div>    
</div>  
