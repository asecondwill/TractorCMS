<article>
	<?php
	$portfolioed_in = "";
	foreach ($portfolio['Tag'] as $tag){
			$portfolioed_in .= "<a href='/portfolios/index/{$tag['keyname']}'>{$tag['name']}</a>  ";
	}
	 echo " <h1>{$portfolio['Portfolio']['title']}</h1>
			 	<p class='meta'> by Will on {$time->niceShort($portfolio['Portfolio']['published'])} 
			 	";
			 	
			 				
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
			 	
echo "	{$portfolio['Portfolio']['body']}		 	<p>
			 		<span class= 'comments'>0 Comments</span>
			 		<span class='tags'>$portfolioed_in</span>
			 	</p>"; ?>	 		
</article>

	<?php echo $this->element("comment_list", array('model'=>'Portfolio', 'id' => $portfolio['Portfolio']['id'])); ?>	

				
				
			
<article>
	<?php 
//	echo $this->element("comment_add", $portfolio['Comment']); 
	?>
	Add Comment Form
</article>
				
	