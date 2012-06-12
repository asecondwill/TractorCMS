<div class="grid_9 alpha">
<h1>Site Contents</h1>
<?php
	echo $this->Tree->generate($contents, array('alias'=>'title')); 
	
?>

</div>

<div class="grid_3 omega">
	<h3>Add Content Items</h3>
	<a href='/admin/contents/add/posts/index'>Add Post Index Content Item</a>
</div>