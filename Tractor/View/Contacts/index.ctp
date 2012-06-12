<?php  $this->Paginator->options(array('url' => $this->passedArgs))  ?>
<div  class="container_12">	
<div class="grid_12 alpha">
			<h1>Blog...</h1>
			
</div>
<div class="alpha grid_3">
				<h3>Contact Topics</h3> <ul id="tagcloud" class="inline">
	<?php 
		echo $this->TagCloud->display($tags, array(
			'before' => '<li style="font-size:%size%px" class="tag">',
			'minSize'=> '9',
			'maxSize'=> '20',
			'named' => 'tag',
			'url' 	 => array('controller' => 'contacts', 'action'=>'index'),
			'after'  => '</li>'));
	?>
	</ul>

</div>


<div  class=" container_12 clearfix">	
		
			<div class="alpha grid_10">
				
				<?php
				if (isset($tag)){
					echo "<h2>Topic: $tag</h2>";
				}
				
	$i = 0;
	foreach ($contacts as $contact):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}else{
			$class = ' class="everow"';
		}
	?>
	<div<?php echo $class;?>>
	<?php
	$contacted_in = "";
	foreach ($contact['Tag'] as $tag){
		$contacted_in .= "<a href='{$content['Content']['path']}/tag/{$tag['keyname']}'>{$tag['name']}</a> // ";
	}
	$contacted_in = substr($contacted_in,0,-4);
	echo 	"<h3><a href='{$contact['Content']['path']}'>{$contact['Content']['title']}</a></h3>
		 	<strong>Contacted in</strong>: $contacted_in
		 	<strong>Published</strong>: {$time->niceShort($contact['Contact']['published'])}
			<p>{$contact['Contact']['excerpt']}</p>
			<p><a class='more' href='{$contact['Content']['path']}'>Read More</a>
			";
			
			//echo $image->resize("/media/" . $contact['Contact']['hero'] , 80, 80, true,array('border'=>'0', 'alt'=> 'hero!'));
			if ($contact['Contact']['hero'] != '') echo   $image->resize("/../media/" . $contact['Contact']['hero'] , 80, 80, true,array('border'=>'0', 'alt'=> $contact['Contact']['hero']));
	
	?>
	
	</div>
					
				
			<?php endforeach; ?>				
				<div class="paging">
		<?php echo $this->Paginator->prev('<< '.__('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next').' >>', array(), null, array('class' => 'disabled'));?>
			</div>
	<small>
		<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</small>

				
			</div>

		</div> <!-- container_12 -->				

		



