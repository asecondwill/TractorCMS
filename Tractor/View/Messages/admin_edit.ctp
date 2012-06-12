
<div class="contents form">
<div class="content-item alpha grid_9">


<h2> 


<?php printf(__('Edit %s'), __('Message')); ?></h2>
<?php echo $this->Form->create('Message');?>
<div class='form-wrap'>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('email');
		echo $this->Form->input('first_name');
		echo $this->Form->input('surname');
		echo $this->Form->input('subscribe');
		echo $this->Form->input('company');
		echo $this->Form->input('address');
		echo $this->Form->input('occupation');
		echo $this->Form->input('details');
		
	?>
	</div>

</div>
	<div class="additional omega grid_3">
		<div>
			<h2>Actions</h2>
			<div class="form-wrap">
<?php 		echo $this->Form->submit('Save Changes');?>
			</div>
		</div>
	</div>
</div>
<?php 		echo $this->Form->end();  ?>

