<?php 
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
echo $this->Form->create('Setting', array('enctype' => 'multipart/form-data'));?>
<div class="siteTexts form">
<div class="content-item grid_9 alpha">
<div class='form-wrap'>
<ul class="tabs">
    <li><a href="#tab1">Site</a></li>
    <li><a href="#tab2">Communications</a></li>
    <li><a href="#tab3">Analytics</a></li>
  <!--  <li><a href="#tab4">Maintenance</a></li> -->
    <li><a href="#tab5">Themes</a></li>   
</ul>
<div class="tab_container">
    <div id="tab1" class="tab_content">
    <?php
	    echo $this->Form->input('site', array('after'=>'Enter The Site Name. This will be used to identify the site.'));
//		echo $this->Form->input('keywords', array('after'=>'Keywords are used by Search engines to index your site. '));
//		echo $this->Form->input('description', array('after'=>''));

			App::import('Utility', 'Folder');
			$folder = new Folder(WWW_ROOT.'/');
		$pic = '';
		if  ($folder->find('favicon.ico')) {
			$pic = $this->Html->image('../favicon.ico', array('alt' => 'Site Icon'));
		}
		echo $this->Form->input('favicon', array('after'=>'Upload your site icon here ' . $pic,'label'=>'Favicon','type'=>'file'));		
    ?>    
    </div>
    <div id="tab2" class="tab_content">
    <?php
   		echo $this->Form->input('system_email', array('after'=>''));
		echo $this->Form->input('system_email_name', array('after'=>''));
    ?>
    </div>
   <div id="tab3" class="tab_content">
   <?php
    echo $this->Form->input('ga_password', array('after'=>''));
		echo $this->Form->input('ga_email', array('after'=>''));
		echo $this->Form->input('ga_account', array('after'=>''));
    ?> 
    </div>
    <div id="tab4" class="tab_content">
    <?php
   		echo $this->Form->input('offline', array('after'=>''));
		echo $this->Form->input('debug_override_ips', array('after'=> 'Comma seperated. Your current IP is: ' .$_SERVER['REMOTE_ADDR']));
    ?>    
    </div>    
    <div id='tab5' class="tab_content themes">    
   
    <?php
		$folder = new Folder(ROOT . DS . "app" . DS . "View" . DS . 'Themed');
		
		$fs = $folder->read();

		foreach ($fs[0] as $dir){						
			$options[$dir] = "<h3>Theme Name: $dir</h3>" . $this->Html->image('/theme/' . $dir . '/img/' . "screenshot.jpg", array('width'=> '250px', 'alt'=>'screenshot.jpg represents the theme. Put it in the folder. 200x200 is good', 'title'=>'This is an example of what the site might look like with this theme')); 
			
			//$options[$dir] = "$dir";
		}
		
				echo $this->Form->input('theme', array(
					'fieldset'=>false, 
					'legend'=>'', 
					'type'=>'radio',   
					'separator' => '</div><div class="theme">',
					'before' => '<div class="theme">',
					'after' => '</div>',
					'options'=>$options
												)
								);
	?>    
    </div>
	<?php
		echo $this->Form->input('id');
	?>
</div>	
</div>	
</div>
</div>
<div class="additional grid_3 omega">
	<div>
	<h2>Actions</h2>
	<div class="form-wrap">		
		<?php echo $this->Form->submit('Save Changes');?>	
	</div>
	</div>
</div>
	<?php echo $this->Form->end();?>