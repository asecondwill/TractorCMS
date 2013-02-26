<!DOCTYPE html>
<html lang="en">
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo __('CMS'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
						
		$this->AssetCompress->AddCss('reset.css');
		$this->AssetCompress->AddCss('960.css');
		$this->AssetCompress->AddCss('text.css');
		$this->AssetCompress->AddCss('brightspark.css');
		$this->AssetCompress->AddCss('brightspark_menu.css');
		$this->AssetCompress->AddCss('jquery.tagsinput.css');
		$this->AssetCompress->AddCss('/../jquery.fancybox/jquery.fancybox.css');		
		echo $this->AssetCompress->includeCss('admin', array('raw'=>false));	

		
		echo $this->Html->script('/ckeditor/ckeditor.js', true);	#dosn't work compresed.
		echo $this->Html->script('jquery.js');
		$this->AssetCompress->addScript('../jquery.fancybox/jquery.fancybox.js');
		$this->AssetCompress->addScript('jquery.tagsinput.js');
		$this->AssetCompress->addScript('jquery.autocomplete.js');
		$this->AssetCompress->addScript('jquery.tablednd_0_5.js');  
		$this->AssetCompress->addScript('tractor.imageselect.js');
		
		
		
		

$a = '	//When page loads...
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content

	//On Click Event
	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});';
$this->Js->buffer($a); 



	?>

</head>
<body>

	<div id="container" class="clearfix">
		<div id="header" class="container_12 clearfix">
		
			<div id='security' >
				<a id='settings' href="/admin/settings">Settings</a> |
				Welcome: <?php echo AuthComponent::user('first_name') . " " .  AuthComponent::user('last_name')?>.  <?php echo $this->Html->link('Logout', array('admin'=>false,'controller' => 'users', 'plugin'=>'',  'action'=>'logout'));  ?>
			</div>
			<h1><a href='/status/'><?php echo $settings['site'] ?><span> <?php echo   __('// Website Administration') //. $sitetexts['Site Name']  ?></span></a></h1>
			<br class="clear"/>
			<div id="menu" class="grid_12 alpha">
			<ul class="sf-menu">
				<li><a href='/admin/contents/'>Content</a>
					<ul>						
						<li><a href="/admin/pages/">Pages</a> </li>
						
						<?php if (is_array(Configure::read('contenttypes'))) echo $this->MTree->contentTypes(Configure::read('contenttypes'));?>
						
					</ul>
				</li>				
				<li><a href='/admin/regions/index'>Blocks</a></li>
				
			<!--	<li><a href='/admin/comments/index/approved'>Comments</a></li>	-->
			
			<?php if (AuthComponent::user('group_id') == 'editor'){ ?>
				<li><a href='#'>Designer</a>
					<ul>
						<li><a href="/admin/contacts">Forms</a></li>					
						<li><a href="/admin/template">Templates</a></li> 		
						<li><a href="#">Security</a>
					<ul>
						<li><a href='/admin/users'>People</a></li>

						<li><a href='/admin/groups'>Groups</a></li>

					</ul>
					
				</li>
					</ul>	
				</li>
			<?php }elseif(AuthComponent::user('group') == 'admin'){ ?>			
					<li><a href='/admin/users'>People</a></li>
			<?php } ?>			
				<li><a href='#'>Menu</a>
					<ul>
						<?php
							foreach($menus_for_admin as $menu){
								echo "<li><a href='/admin/menu_items/index/{$menu['Menu']['id']}'>{$menu['Menu']['name']}</a></li>";
							}
						?>
						<li><a href='/admin/menus/add'>Add a Menu</a></li>
					</ul>
				</li>	
				<li><a href='/admin/messages/index'>Messages</a></li>			
							
				<li><a href="/admin/media">Media</a></li>
				
			<!--	<li>
					<a href='/admin/orders/'>Orders</a>
				</li>
				-->					
			</ul>				
			<!--<div id="search">
				<form>
					<input />
					<input type="submit" value='search' class='button'>
				</form>
			</div>-->			
			</div>						
		</div>
		<div id="content" class="container_12 clearfix">
			<?php echo $this->Session->flash(); ?>
			<?php echo $content_for_layout; ?> 
		</div>		
		<div  class="container_12">
		<div id="footer" class="grid_12 alpha clearfix">
			<!--Tractor Site Administration by <a href='http://www.aSecondSystem.com'>aSecondSystem.com</a> -->
			<a target="_blank" href='http://www.asecondsystem.com/pages/view/tractor-cms'><img src="/img/tractor/powered-by-tractor.png"/></a>
			</div>
		</div>
	</div>
<script>
	//CKEDITOR.replace('data[Content][body]', {filebrowserBrowseUrl: '/ckeditor/filemanager/index.html'});
</script>
	
	<?php
	echo $scripts_for_layout; 
	echo $this->AssetCompress->includeJs('admin', array('raw'=>true));	
	echo $this->Js->writeBuffer();
	
	?>
	
</body>
</html>