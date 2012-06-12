<?php 
$a = '	//When contact loads...
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

<div class="content-item grid_8 alpha">


<?php echo $this->Form->create('Contact');?>
<?php echo $this->Form->input('id'); ?>
<div class='form-wrap'>
<ul class="tabs">
    <li><a href="#tab1">Content</a></li>
   
    
    <li><a href="#tab4">SEO</a></li>
    <li><a href="#tab5">Behaviour</a></li> 
    <li><a href="#tab6">Structure</a></li>    
</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <?php echo $this->Form->input('title'); 
        echo $this->Form->input('body', array('class'=>'ckeditor'));
        ?>        
    </div>
  


	<div id="tab4" class="tab_content">
		<?php echo $this->element('tractor/admin/contentfields'); ?>
    </div>
    <div id="tab5" class="tab_content">
       
    </div>
    
     <div id="tab6" class="tab_content">
       <?php  echo $this->Form->input('Content.parent_id', array('options'=>$content_options, 'empty'=>'Top Level')); ?>
    </div>
    

</div>

	</div>

</div>

	<div class="additional grid_4 omega">
		<div>
			<h2>Actions</h2>
			<div class="form-wrap">
				<?php 		echo $this->Form->submit('Save Changes', array('after'=>" &nbsp;<a href=\"../index\">Cancel</a>"));?> &nbsp; 
			</div>
		</div>
		
		
	

	</div>

<?php 		echo $this->Form->end();  ?>

