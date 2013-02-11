<?php
$selected_id = "none";
if (isset($selected_item)) $selected_id = $selected_item['MenuItem']['id'];
echo $this->Html->script(array('jquery.js','jquery.tablednd_0_5.js'));

$this->Paginator->options(array('url' => $this->passedArgs));
   
?>
<script type="text/javascript">
$(document).ready(function() {
    // Initialise the table
    $("#MenuItem-table").tableDnD({
    	onDrop: function(table, row){
    		//alert( $.tableDnD.serialize());
				$.post('/admin/MenuItems/order/', {'mode': 'reorder', 'ids': $.tableDnD.serialize()},
			function(data) {
				// Whatever you want to do here
			}
		)}, 
        dragHandle: "drag-handle"
    	}
		)});
</script>
<div class="contents index">
	<div id='menu_name' class="content-item grid_12 alpha">
	<h2>Edit Menu</h2>
	<?php
		echo $this->Form->create('Menu' , array('action'=>'admin_edit'));
		echo $this->Form->input('Menu.id' );
		echo $this->Form->input('name', array('label'=>'Menu Name:'));
		 echo $this->Form->submit('Save');
		 echo "<div class='delete'>";
		 echo $this->Html->link($this->Html->image('admin/trash.gif'), array('controller'=>'menus','action'  => 'delete', $menu['Menu']['id']), array('escape'=>false), sprintf(__('Are you sure you want to delete # %s?'), $menu['Menu']['name']), array('class'=>'delete'));
		 echo "</div>";
		echo $this->Form->end();?>
	</div>
	
	<div class="content-item grid_3 alpha">
	<h2>Menu Items</h2>
	<div class="list">
	<?php	 echo $this->MTree->show('MenuItem/title', $items);	?>
	</div>
	</div>
	<div class="content-item grid_5	">
		<h2>Menu Items  <?php if(isset($selected_item))echo " - " . $selected_item['MenuItem']['title'] ?>
		<div class="action">
			<?php 
			if(isset($selected_item)){
				echo $this->Html->link('+',  array('action' => 'add',  $menu_id, $selected_item['MenuItem']['id']  ));			
			}else{
				echo $this->Html->link('+',  array('action' => 'add',  $menu_id  ));			
			}
			 
			  ?>
		</div>
		</h2>
		<table id='MenuItem-table' cellpadding="0" cellspacing="0">
		<tr class="nodrag nodrop">
			<td></td>
			<th>Link</th>
			<th>Title</th>
	
			<th class="actions"><?php echo __('Actions');?></th>
		</tr>
		<?php
		$i = 0;
		foreach ($menuItems as $menuItem):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
			<tr id='<?php echo $menuItem['MenuItem']['id'] ?>' <?php echo $class;?>>
				<td class="drag-handle"></td>
				<td>
					<?php echo $menuItem['MenuItem']['link']; ?>
				</td>
				<td>
					<?php echo $menuItem['MenuItem']['title']; ?>
				</td>
										
				<td class="actions">
				
					<?php 
					echo $this->Html->image('admin/application_edit.png',  array('alt' => 'edit',  'url' => array('action' => 'edit', $menu_id, $selected_id, $menuItem['MenuItem']['id'])));
					
			
?>
					<?php echo $this->Html->link($this->Html->image('admin/trash.gif'), array('action' => 'delete', $menuItem['MenuItem']['id'], $menu['Menu']['id']), array('escape'=>false), __('Are you sure you want to delete this?'), array('class'=>'delete')); ?>
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
	<div class="content-item grid_4 omega">
	<h2>Add Pages</h2>
	<div class="add_items">
	<?php

	#hackety hack.  its because its a rush. more haste, rubbish code.
	if($selected_id == 'none')$selected_id =null;
	//	debug($selected_id);
		foreach($pages as $page){
			echo $this->Form->create('MenuItem', array('url'=>'/admin/menu_items/index/' . $menu_id . "/" . $selected_id)	);
			
			echo $this->Form->input('link', array('type' => 'hidden','value'=>  $page['Content']['path']));
			//echo "<div class='pathy'>" . str_repeat("--", $page['Content']['depth']) . $page['Content']['path'] . "</div>";
			echo "<div class='add_items_prefix'>" . str_repeat("-", $page['Content']['depth']-1) . "</div>" . $this->Form->input('title',array('value'=>$page['Content']['title']) );
			echo $this->Form->input('content_id', array('type'=>'hidden','value'=>$page['Content']['id']));
			
			echo $this->Form->input('parent_id', array('type'=>'hidden', 'value'=> $selected_id));
			echo $this->Form->input('menu_id', array('type'=>'hidden', 'value'=> $menu_id));
			
			echo $this->Form->submit('+'); 
			 echo $this->Form->end();
			 
		}
	
	?>
	</div></div>	
	<div class="help grid_12">
		<h4>Adding a menu to a template</h4>
		<div>
			Use code snippets like this to add a menu to your template
			<code> echo $this->element('Menu/show', array('name'=>'<?php echo $menu['Menu']['name']?>', 'level'=>0, 'after'=>"", 'li'=>true));</code>
		</div>
		
		<h4>Adding a menu to content</h4>
		<div>
			Use short codes to add a menu to a content area that is being proccessed by  $layout->filter
			<code> [element:Menu/show name=<?php echo $menu['Menu']['name']?> after= / level=0 li=false] </code>
		</div>
			
	</div>
	</div>	
	
