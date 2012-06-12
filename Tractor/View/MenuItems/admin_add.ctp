<?php //debug($menu_id . " " . $parent_id);?>

<?php echo $this->Form->create('MenuItem', array('url'=>'/admin/menu_items/add/' . $menu_id . "/" . $parent_id)	);?>
<div class="contents form">
<div class="content-item">


<h2><?php echo __('Add Menu Item' );?></h2>
	<div class='form-wrap'>
	<?php
		echo $this->Form->input('id');

		echo $this->Form->input('parent_id', array('type'=>'hidden', 'value'=> $parent_id));
		echo $this->Form->input('menu_id', array('type'=>'hidden', 'value'=> $menu_id));
		
		echo $this->Form->input('link');
		echo $this->Form->input('title');
		
		echo $this->Form->input('external');
		//echo $this->TractorInputs->selectImage(array(), 'png', 'Image', 'MenuItem');
		
			?>
	</div>

</div>
	<div class="additional">
		<div>
			<h2>Actions</h2>
			<div class="form-wrap">
			<?php echo $this->Form->submit('Save Changes'); ?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Form->end();?>