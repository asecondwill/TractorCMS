<?php echo $this->Form->create('Menu');?>
<div class="siteTexts form grid_9 alpha">
<div class="content-item">
<h2><?php echo __('Add Menu');?></h2>
<div class='form-wrap'>
	<?php
		
		echo $this->Form->input('name');
		
	?>
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