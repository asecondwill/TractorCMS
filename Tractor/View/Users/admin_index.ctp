<div class="contents index">
	<div class="content-item alpha grid_12">

<h2><?php echo __('Users');?>		<div class="action">
		
			<?php 
echo $this->Html->link('+',  array('action' => 'add' ));

			 ?>
		</div>
</h2>

<table cellpadding="0" cellspacing="0">
<tr>

	<th><?php echo $this->Paginator->sort('username');?></th>
	<th><?php echo $this->Paginator->sort('email');?></th>
	

	<th><?php echo $this->Paginator->sort('group_id');?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($users as $user):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $user['User']['username']; ?>
		</td>
		<td>
			<?php echo $user['User']['email']; ?>
		</td>
		<!-- <td>
			<?php echo $user['User']['confirmed'] ? "yes" : "no"; ?>
		</td>
		 -->
		<td>
			<?php echo $user['Group']['name']; ?>
		</td>
		<td class="actions">
				
					<?php 
					echo $this->Html->image('admin/application_edit.png',  array('alt' => 'edit',  'url' => array('action' => 'edit', $user['User']['id'])));
					
					echo $this->Html->image('admin/application_key.png',  array('alt' => 'password',  'url' => array('action' => 'password', $user['User']['id'])));

					
			
?>
					<?php echo $this->Html->link($this->Html->image('admin/trash.gif'), array('action' => 'delete', $user['User']['id']), array('escape'=>false), sprintf(__('Are you sure you want to delete # %s?'), $user['User']['username']), array('class'=>'delete')); ?>
				</td>
				
		
	</tr>
<?php endforeach; ?>
</table>

<div class="paging">
	<?php echo $this->Paginator->prev('<< '.__('previous'), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $this->Paginator->numbers();?>
	<?php echo $this->Paginator->next(__('next').' >>', array(), null, array('class' => 'disabled'));?>
<?php
echo $this->Paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
));
?>
</div>
</div>	
</div>

