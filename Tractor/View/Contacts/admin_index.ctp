
	<?php  $this->Paginator->options(array('url' => $this->passedArgs))  ?><div class="contents index">
	<div class="content-item grid_12 alpha">
		<h2><?php echo __('Contacts');?>		<div class="action">
<?php echo  $this->Html->link('+',  array('action' => 'add' )) ;?>
</div>
		</h2>
 

<div class="contacts index">
	
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php // echo  $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php  echo  $this->Paginator->sort('Path','path');?></th>
			<th><?php // echo  $this->Paginator->sort('excerpt');?></th>
			<th><?php // echo  $this->Paginator->sort('body');?></th>
			<th><?php // echo  $this->Paginator->sort('hero');?></th>
			<th><?php // echo  $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php // echo  $this->Paginator->sort('description');?></th>
			<th><?php // echo  $this->Paginator->sort('keywords');?></th>
			<th><?php // echo  $this->Paginator->sort('metatitle');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($contacts as $contact):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php // echo ($contact['Contact']['id']); ?>&nbsp; </td>
		<td><?php echo ($contact['Contact']['title']); ?>&nbsp; </td>
		<td><a target='_blank' href='<?php echo $contact['Content']['path'] ?>'><?php echo Configure::read('site'); ?><?php echo $contact['Content']['path'] ?></a>&nbsp; </td>
		<td><?php // echo ($contact['Contact']['excerpt']); ?>&nbsp; </td>
		<td><?php // echo ($contact['Contact']['body']); ?>&nbsp; </td>
		<td><?php // echo ($contact['Contact']['hero']); ?>&nbsp; </td>
		<td><?php // echo ($contact['Contact']['created']); ?>&nbsp; </td>
		<td><?php echo $this->Time->niceShort($contact['Contact']['modified']); ?>&nbsp; </td>
		<td><?php // echo ($contact['Contact']['description']); ?>&nbsp; </td>
		<td><?php // echo ($contact['Contact']['keywords']); ?>&nbsp; </td>
		<td><?php // echo ($contact['Contact']['metatitle']); ?>&nbsp; </td>
		<td class="actions">
			<?php echo $this->Html->image('admin/application_edit.png',  array('alt'=>'edit', 'url' => array('action'=> 'edit', $contact['Contact']['id']))); ?>
			<? echo $this->Html->link($this->Html->image('admin/trash.gif'), 
				array('escape'=>false, 
					  'action' => 'delete', 
					   $contact['Contact']['id']
					 ), 
			 	array('escape'=>false), 
			 	sprintf(__('Are you sure you want to delete # %s?'), 
			 	$contact['Contact']['title']), 
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
	'format' => __('Contact %page% of %contacts%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</small>
	</div>
</div>
</div>