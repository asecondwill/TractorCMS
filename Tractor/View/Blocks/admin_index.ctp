
<?php

$this->Html->script(array('jquery.js','jquery.tablednd_0_5.js'), false);


$this->Paginator->options(array('url' => $this->passedArgs));
   
?>
<script type="text/javascript">
$(document).ready(function() {
    // Initialise the table
    $("#block-table").tableDnD({
    	
    	
    	onDrop: function(table, row){
    		//alert( $.tableDnD.serialize());
				$.post('/admin/Blocks/order/', {'mode': 'reorder', 'ids': $.tableDnD.serialize()},
			function(data) {
				// Whatever you want to do here
			}
    	
		)}, 
        dragHandle: "drag-handle"

    	}
		
		)});
</script>


<div class="contents index">
	<div class="content-item grid_12 alpha">
		<h2> Blocks  <?php if (!empty($region)) echo " - " . $region['Region']['title'] ?>
		<div class="action">
		
			<?php 
echo $this->Html->link('+',  array('action' => 'add', $region['Region']['id'] ));

			 ?>
		</div>
		</h2>
		
		
		<table id='block-table' cellpadding="0" cellspacing="0">
		<tr class="nodrag nodrop">
			<td></td>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort('region');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			
			
			<th class="actions"><?php echo __('Actions');?></th>
		</tr>
		<?php
		$i = 0;
		foreach ($blocks as $block):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
			<tr id='<?php echo $block['Block']['id'] ?>' <?php echo $class;?>>
				<td class="drag-handle"></td>
				<td>
					<?php echo $block['Block']['title']; ?>
				</td>
				<td>
					<?php echo $block['Region']['title']; ?>
				</td>
				<td>
					<?php echo $this->Time->niceShort($block['Block']['created']); ?>
				</td>
										
				<td class="actions">
				
					<?php 
					echo $this->Html->image('admin/application_edit.png',  array('alt' => 'edit',  'url' => array('action' => 'edit', $block['Block']['id'])));
					
			
?>
					<?php echo $this->Html->link($this->Html->image('admin/trash.gif'), array('action' => 'delete', $block['Block']['id']),  array('escape'=>false), __('Are you sure you want to delete this?'), array('class'=>'delete')); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
		<div class="paging">
			<?php echo $this->Paginator->prev('<< '.__('previous'), array(), null, array('class'=>'disabled'));?>
		 | 	<?php echo $this->Paginator->numbers();?>
			<?php echo $this->Paginator->next(__('next').' >>', array(), null, array('class' => 'disabled'));?>
			<small><?php
		$this->Paginator->options(array('url' => $this->passedArgs));
		echo $this->Paginator->counter(array(
		'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
		));
		?></small>
		</div>
		</div>
		
	</div>	