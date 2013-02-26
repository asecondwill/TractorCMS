<article>
	<?php
	$posted_in = "";
	foreach ($post['Tag'] as $tag){
			$posted_in .= "<a href='/posts/index/{$tag['keyname']}'>{$tag['name']}</a>  ";
	}
	 echo " <h1>{$post['Post']['title']}</h1><p class='meta'> by Will on {$this->Time->niceShort($post['Post']['published'])} ";
	
	$geshi->showPlainTextButton = false;
	
	echo $this->Geshi->highlight($post['Post']['body']);
	 			
	echo "		 	
			 	
			 	
			 	<p>
			 		<span class= 'comments'>0 Comments</span>
			 		<span class='tags'>$posted_in</span>
			 	</p>"; ?>	 		
</article>

	<?php echo $this->element("comment_list", array('model'=>'Post', 'id' => $post['Post']['id'])); ?>	

				
				
			
<article>
	<?php 
//	echo $this->element("comment_add", $post['Comment']); 
	?>
	Add Comment Form
</article>
				
	