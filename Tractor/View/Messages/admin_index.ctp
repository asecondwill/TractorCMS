
	<?php  $this->Paginator->options(array('url' => $this->passedArgs))  ?><div class="contents index">
	<div class="content-item alpha grid_12">
		<h2><?php echo __('Messages');?>		<div class="action">

</div>
		</h2>
 

<div class="messages index">
	
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php // echo  $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('email');?></th>
			<th><?php echo $this->Paginator->sort('first_name');?></th>
			<th><?php echo $this->Paginator->sort('surname');?></th>
			<th><?php echo $this->Paginator->sort('subscribe');?></th>
		
			<th><?php echo $this->Paginator->sort('contacts_id');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($messages as $message):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php // echo ($message['Message']['id']); ?>&nbsp; </td>
		<td><?php echo ($message['Message']['email']); ?>&nbsp; </td>
		<td><?php echo ($message['Message']['first_name']); ?>&nbsp; </td>
		<td><?php echo ($message['Message']['surname']); ?>&nbsp; </td>
		<td><?php echo ($message['Message']['subscribe']); ?>&nbsp; </td>
		
		
		
		
		<td><?php echo ($message['Contacts']['title']); ?>&nbsp; </td>
		<td class="actions">
			<?php echo $this->Html->image('admin/application_edit.png',  array('alt'=>'edit', 'url' => array('action'=> 'edit', $message['Message']['id']))); ?>
			<? echo $this->Html->link($this->Html->image('admin/trash.gif'), 
				array('escape'=>false, 
					  'action' => 'delete', 
					   $message['Message']['id']
					 ), 
			 	array('escape'=>false), 
			 	sprintf(__('Are you sure you want to delete # %s?'), 
			 	$message['Message']['email']), 
			 	array('escape'=>'false', 'class'=>'delete')); ?>		</td>
	</tr>
<?php endforeach; ?>
	</table>
	
	
	<div class="paging">
		<?php echo $this->Paginator->prev('<< '.__('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next').' >>', array(), null, array('class' => 'disabled'));?>
	<small>
		<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</small>
	</div>
</div>
</div>