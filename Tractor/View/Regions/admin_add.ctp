<?php echo $this->Form->create('Region');?>
<div class="regions form">
<div class="content-item alpha grid_9">
<h2><?php echo __('Add Region');?></h2>
<div class='form-wrap'>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		
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