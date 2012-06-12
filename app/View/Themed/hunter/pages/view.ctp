<section class="page clearfix">
	<?php echo $this->element('social'); ?>
	<div id="crumbs">
		<?php echo $this->element('tractor/nav/crumbs') ?>	
	</div>
		
	<aside>
		
	 <div class="aside_item more_info">
      <h2>More Information</h2>
      <ul>
         <li><a href='/send-to-friend'>Email to a friend</a></li>
        <li><a href='<?php echo $content['Content']['path'] ?>' title='<?php echo $content['Content']['title'] ?>' class='jQueryBookmark'>Bookmark this page</a></li>
       
      </ul>
    </div>	
		
		<?php //echo $this->element('Event/latest', array("number_of_events"=>3)); ?>		
		<?php echo $this->element('subscribe'); ?>

	
		
		
		
	</aside>
		
	<article>
		<h1 class="page"><?php echo $content['Page']['title'];?></h1>
		
		
		<?php echo $this->Layout->filter($content['Page']['body']);?>
	</article>
</section>
