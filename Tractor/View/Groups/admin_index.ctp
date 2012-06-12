<div class="contents index">
	<div class="content-item">

<h2><?php echo __('Groups');?>	<div class="action">
		
			<?php echo $this->Html->link('+',  array('action' => 'add' ));?>
		</div>
</h2>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($groups as $group):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
	
		<td>
			<?php echo $group['Group']['name']; ?>
		</td>
		<td class="actions">
				
					<?php 
					echo $this->Html->image('admin/application_edit.png',  array('alt' => 'edit',  'url' => array('action' => 'edit', $group['Group']['id'])));
					
			
?>
					<?php echo $this->Html->link($this->Html->image('admin/trash.gif'), array('action' => 'delete', $group['Group']['id']), array('escape'=>false), sprintf(__('Are you sure you want to delete # %s?'), $group['Group']['name']), array('class'=>'delete')); ?>
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
