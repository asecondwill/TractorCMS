
<div class="contents index">
<div class="content-item grid_12 alpha">
<h2><?php echo __('Regions');?>
<div class="action">
		
			<?php 
			  echo $this->Html->link('+',  array('action' => 'add' ));

			 ?>
		</div>
</h2>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('title');?></th>
	<th class="actions"><?php echo __('Actions');?></th>
	
</tr>
<?php
$i = 0;
foreach ($regions as $region):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $region['Region']['title']; ?>
		</td>
		
		<td class="actions">
		<?php echo $this->Html->image('admin/brick.png',  array('alt' => 'View Blocks', 'title' => 'View Blocks',  'url' => array('action' => 'index', 'controller'=>'blocks', $region['Region']['id'])));
 ?>
&nbsp;&nbsp;&nbsp;&nbsp;
			<?php 
						
					echo $this->Html->image('admin/application_edit.png',  array('alt' => 'edit',  'url' => array('action' => 'edit', $region['Region']['id'])));
					
			
?>
					<?php 
 echo $this->Html->link($this->Html->image('admin/trash.gif'), array('action' => 'delete', $region['Region']['id']), array('escape'=>false), sprintf(__('Are you sure you want to delete # %s?'), $region['Region']['title']), array('class'=>'delete')); ?>
 
 
		
		
			
		</td>
		
	</tr>
<?php endforeach; ?>
</table>

<div class="paging">
	<?php echo $this->Paginator->prev('<< '.__('previous'), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $this->Paginator->numbers();?>
	<?php echo $this->Paginator->next(__('next').' >>', array(), null, array('class' => 'disabled'));?>
	<small>
<?php
echo $this->Paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
));
?></small>
</div>
</div>
</div>



