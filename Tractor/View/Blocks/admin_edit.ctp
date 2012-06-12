
<?php echo $this->Form->create('Block');?>
<div class="regions form">
<div class="content-item alpha grid_9">
<h2><?php echo __('Add Region');?></h2>
<div class='form-wrap'>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('region_id');
		echo $this->Form->input('title');
		echo $this->Form->input('alias');
	//	echo $this->Form->input('body');
	
		echo "<h3>Body</h3>";
		echo $this->Form->textarea('Block.body',  array('class'=>'ckeditor', 'label'=>'body'));
	//	echo $this->Form->input('show_title');
		echo $this->Form->input('class');
	//	echo $this->Form->input('status');
	//	echo $this->Form->input('weight');
		echo $this->Form->input('element');
	//	echo $this->Form->input('visibility_roles');
	//	echo $this->Form->input('visibility_paths');
	//	echo $this->Form->input('visibility_php');
	//	echo $this->Form->input('params');
	?>
	</div>	
</div>
</div>
<div class="additional omega grid_3">
	<div>
	<h2>Actions</h2>
	<div class="form-wrap">
				<?php echo $this->Form->submit('Save Changes');?>
	
	</div>
	</div>
</div>
	<?php echo $this->Form->end();?>