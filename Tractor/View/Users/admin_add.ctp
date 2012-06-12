<?php echo $this->Form->create('User');?>

<div class="contents form">
<div class="content-item grid_9 alpha">
<h2>Add User</h2>
<div class="form-wrap">

	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('username');
		echo $this->Form->input('email');
		echo $this->Form->input('passwd', array('label'=>'Password', 'autocomplete'=>'off'));
		echo $this->Form->input('group_id');
		echo $this->Form->input('confirmed', array('value'=>1, 'type'=>'hidden'));
	?>

</div>

</div>
</div>
<div class="additional grid_3 omega">
		<div>
			<h2>Actions</h2>
				<div class='form-wrap'>
				<?php echo $this->Html->link(__('Cancel'), array('action' => 'index'));?>
				
			
				
			<?php echo $this->Form->submit('Save Changes'); ?>
			
			</div>
		</div>
	</div>
</div>

<?php echo $this->Form->end();?>