<?php echo $this->Form->create('User');?>

<div class="contents form">
	<div class="content-item alpha grid_9">
		<h2>Edit User</h2>
		<div class="form-wrap">
			<?php
			echo $this->Form->input('id');
			echo $this->Form->input('passwd', array('label'=>'Password',  'autocomplete'=>'off'));
			
			?>
		</div>
	</div>
</div>
<div class="additional omega grid_3">
		<div>
			<h2>Actions</h2>
				<div class='form-wrap'>
					<?php echo $this->Html->link(__('Cancel'), array('action' => 'index'));?>				
				<?php echo $this->Html->link($this->Html->image('admin/trash.gif'), array('action' => 'delete', $this->Form->value('User.id')), array('escape'=>false), sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('User.username')), array('class'=>'delete')); ?>
			<?php echo $this->Form->submit('Save Changes'); ?>			
				</div>
		</div>
</div>


<?php echo $this->Form->end();?>