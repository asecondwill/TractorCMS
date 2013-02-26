<!-- rendering app/view/elements/crumbs.ctp -->
<!-- create a corresponding element in your theme directory to override this functionality / presentation -->
<!-- use $path to make your trail -->

<a href='/'>Home</a> 
<?php 
if(isset($path)){
	foreach($path as $crumb){
		if($crumb){
			if ($crumb['Content']['path'] == $this->request->here){
					  
					  if($crumb{'Content'}{'path'} != '/home') echo " > {$crumb['Content']['title']} ";
			}else{
				 echo " > <a href='{$crumb['Content']['path']}'>{$crumb['Content']['title']}</a>  ";
			}	 
		}	 
	}
}else{
	echo " > " . $title;
}
