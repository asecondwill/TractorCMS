
<?php
$posts = Cache::read("posts_$number_of_posts");
if ($posts == false){
	$posts =	$this->requestAction(array('controller' => 'posts', 'action' => 'latest'), array('pass' => array(  $number_of_posts , 'desc', 'published'	)));
}


if ($posts){
	if (!$detail) echo "<ul class='latest_list'>";
	foreach($posts as $post){
		$posted_in = "";
		foreach ($post['Tag'] as $tag){
			$posted_in .= "<a href='/posts/index/{$tag['keyname']}'>{$tag['name']}</a>  ";
		}
		
		
		if ($detail){
			echo 	"<article><h1><a href='/posts/view/{$post['Content']['slug']}'>{$post['Post']['title']}</a></h1>
			 	<p class='meta'> by Will on {$time->niceShort($post['Post']['published'])} </p>
			 	<p>{$post['Post']['excerpt']} </p>
			 	<p><a class='more' href='/posts/view/{$post['Content']['slug']}'>Read More</a>
			 	<p>
			 		<span class= 'comments'>0 Comments</span>
			 		<span class='tags'>$posted_in</span>
			 	</p>
			 	
				</article>
				";
		}else{
			echo 	"<li><a href='/posts/view/{$post['Post']['slug']}'>{$post['Post']['title']}</a></</li>				";
		}
	
	}
	if (!$detail) echo "</ul>";
}

?>			
			<article>	<a class="more" href='/posts'>More from the note book</a></article>

