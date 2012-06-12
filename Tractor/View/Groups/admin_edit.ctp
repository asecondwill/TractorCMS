<?php echo $this->Form->create('Group');?>
<div class="contents form">
<div class="content-item">
<h2>Edit Group</h2>
<div class='form-wrap'>

	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
	?>


</div>

</div>
</div>
<div class="additional">
		<div>
			<h2>Actions</h2>
				<div class='form-wrap'>
				<?php echo $this->Html->link(__('Cancel'), array('action' => 'index'));?>
				
				<?php echo $this->Html->link($this->Html->image('admin/trash.gif'), array('action' => 'delete', $this->Form->value('Group.id')), array('escape'=>false), sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Group.name')), array('class'=>'delete')); ?>
			
				
			<?php echo $this->Form->submit('Save Changes'); ?>
			
			</div>
		</div>
	</div>
</div>
<?php echo $this->Form->end();?>