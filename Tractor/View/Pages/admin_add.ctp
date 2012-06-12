

<div class="content-item grid_8 alpha">


<?php echo $this->Form->create('Page');?>
<?php echo $this->Form->input('id'); ?>
<div class='form-wrap'>
<ul class="tabs">
    <li><a href="#tab1">Content</a></li>
    <li><a href="#tab2">Related</a></li>
    <li><a href="#tab3">Meta Info</a></li>
    <!--<li><a href="#tab4">SEO</a></li> -->
    <li><a href="#tab5">Behaviour</a></li> 
    <li><a href="#tab6">Structure</a></li>    
</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <?php echo $this->Form->input('title'); 
        echo $this->Form->input('body', array('class'=>'ckeditor'));
        ?>        
    </div>
    <div id="tab2" class="tab_content">
       <?php
         echo $this->element('tractor/admin/inputs/related', array(
        												'hint'=>"Choose 4 related Events for the home page", 
        												'class_name'=>'', 
        												'field'=>'featured_events',
        												'allowed_class_names' => 'events|eventcategories'
        												));
       ?>
    </div>

    <div id="tab3" class="tab_content">
    	<?php
    		echo $this->Form->input('excerpt');   
					
    	?>	
    </div>
	<div id="tab4" class="tab_content">
	 <!-- seo -->
		<?php //echo $this->element('tractor/admin/contentfields'); ?>
    </div>
    <div id="tab5" class="tab_content">
     <!-- behaviour -->
      <?php echo $this->element('tractor/admin/layoutoptions'); ?>
      <?php echo $this->Form->input('Content.action_name', array('type'=>'hidden', 'value'=>'view')); ?>  
    </div>
    
     <div id="tab6" class="tab_content">
     <!-- structure -->
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

