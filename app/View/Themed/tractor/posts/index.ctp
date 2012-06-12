<?php  $paginator->options(array('url' => $this->passedArgs))  ?>


<div  class=" container_12 clearfix">	
		
			<div class="alpha grid_10">
				
				<?php
				if (isset($tag)){
					echo "<h2>Topic: $tag</h2>";
				}
				
	$i = 0;
	foreach ($posts as $post):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}else{
			$class = ' class="everow"';
		}
	?>
	<article <?php echo $class;?>>					
		<?php	
		$posted_in = "";
		foreach ($post['Tag'] as $tag){
			$posted_in .= "<a href='/posts/index/{$tag['keyname']}'>{$tag['name']}</a>  ";
		}
		
		echo 	"<h1><a href='/posts/view/{$post['Content']['slug']}'>{$post['Post']['title']}</a></h1>
			 	<p class='meta'> by Will on {$time->niceShort($post['Post']['published'])} </p>
			 	<p>{$post['Post']['excerpt']} <p>
			 	<p><a class='more' href='/posts/view/{$post['Content']['slug']}'>Read More</a>
			 	<p>
			 		<span class= 'comments'>0 Comments</span>
			 		<span class='tags'>$posted_in</span>
			 	</p>
			 	
				</article>
				";			
	?>					
				
			<?php endforeach; ?>				
<article class="paging">
<small>
		<?php echo $this->Paginator->prev('<< '.__('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next').' >>', array(), null, array('class' => 'disabled'));?>
			
	<small>
	<p>
		<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>
	</p>	</small>

				
</article>
		



