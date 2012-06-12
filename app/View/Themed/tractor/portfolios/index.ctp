<?php  $paginator->options(array('url' => $this->passedArgs))  ?>


<div  class=" container_12 clearfix">	
		
			<div class="alpha grid_10">
				
				<?php
				if (isset($tag)){
					echo "<h2>Topic: $tag</h2>";
				}
				
	$i = 0;
	
	foreach ($portfolios as $portfolio):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}else{
			$class = ' class="everow"';
		}
	?>
	<article <?php echo $class;?>>					
		<?php	
		$portfolioed_in = "";
		foreach ($portfolio['Tag'] as $tag){
			$portfolioed_in .= "<a href='/portfolios/index/{$tag['keyname']}'>{$tag['name']}</a>  ";
		}
		
		echo 	"<h1><a href='/portfolios/view/{$portfolio['Content']['slug']}'>{$portfolio['Portfolio']['title']}</a></h1>
			 	<p class='meta'> by Will on {$time->niceShort($portfolio['Portfolio']['published'])} </p>";
			 
			
$heros = explode(",",$portfolio['Portfolio']['hero']);

foreach($heros as $key => $item)
{
   if(trim($item) == "")
   {
       unset($heros[$key]); //Remove from teh array.
   }
}
$heros_str = implode($heros);
$heros = explode(",", $heros_str);

echo   $image->resize("/../media/" . $heros[0] , 560, 400, true,array('border'=>'0', 'alt'=> $heros[0]));
			 	
			 echo "	{$portfolio['Portfolio']['excerpt']} 
			 	<p><a class='more' href='/portfolios/view/{$portfolio['Content']['slug']}'>Read More</a>
			 	<p>
			 		<span class= 'comments'>0 Comments</span>
			 		<span class='tags'>$portfolioed_in</span>
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
		



