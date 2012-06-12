<style >
#element-table .drag-handle{
	display: none;
}
#selected-items .action{
content: "-";
	
}
.save{

	width: 200px;
}
.pop{
	width: 300px;
}
#element-table{
	
}
</style>
<script type="text/javascript">
$(document).ready(function() {
    // Initialise the table
	
	
	    
    $("#selected-items .action").live('click', function(event) {
        $(this).parent().parent().remove();
	});

	 $("#element-table .action").live('click', function(event) {
	 	$('#selected-items').append($(this).parent().parent().clone());
	 	
	 	$("#selected-items").tableDnD({
        dragHandle: "drag-handle"
    	})
});


   
    $("#selected-items").tableDnD({
        dragHandle: "drag-handle"
    	})
    $("#element-table").tableDnD({
        dragHandle: "drag-handle"
    	})
	
    	
    	});
</script>


<div class="contents index">
	<div class="content-item pop">
		<h2><?php echo $content_type?></h2>
		
		<div class="pick">
		<table id='element-table' cellpadding="0" cellspacing="0">
		<tr class="nodrag nodrop">
			<th>Copy</th>
			
			<th class="actions"></th>
		</tr>
		<tbody class="pick">
		<?php
		$i = 0;
		foreach ($pages as $page):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
			<tr id='<?php echo $page['Content']['id'] ?>' <?php echo $class;?>>
				<td class="drag-handle"></td>
				<td>
					<?php echo substr( $page['Content']['title'], 0, 30); ?>
				</td>
				
								
				<td class="actions">
					<a class="action" href="#">+/-</a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
		</table>
		</div>	
	</div>
			
	<div class="additional">
		<div>
		<h2>Selected <?php echo $content_type?></h2>
			<table id='selected-items'>
			<thead>
			<tr class="nodrag nodrop">
			<td></td>
			<th>Copy</th>
			
			<th class="actions"></th>
			
		</tr>
		</thead>
		<tbody>
		<?php
		$i = 0;
		if (isset($selected_pages)){
					foreach ($selected_pages as $page):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
			<tr id='<?php echo $page['Content']['id'] ?>' <?php echo $class;?>>
				<td class="drag-handle"></td>
				<td>
					<?php echo substr( $page['Content']['title'], 0, 30); ?>
				</td>
								
				<td class="actions">
					<a class="action" href="#">+/-</a>
				</td>
			</tr>
		<?php endforeach; 
		
		}?>
		</tbody>		
			</table>
		</div>
		
	</div>			
		<div class="additional save">
			<div>
			<h2>Actions</h2>
			<a class="save-elements-button<?php echo $field_name  ?> button" id='save_to_form' >Save</a>
		</div>
		</div>
</div>	
