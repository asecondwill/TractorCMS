<?php echo $this->Form->create('Group');?>
<div class="contents form">
<div class="content-item">
<h2>Add Group</h2>
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
			
				
			<?php echo $this->Form->submit('Save Group'); ?>
			
			</div>
		</div>
	</div>
</div>
<?php echo $this->Form->end();?>