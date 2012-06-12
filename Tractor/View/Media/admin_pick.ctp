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
		<h2>Images</h2>
		
		<div class="pick">
		<table id='element-table' cellpadding="0" cellspacing="0">
		<tr class="nodrag nodrop">
			<th>Copy</th>
			<th>Image</th>
			<th class="actions"></th>
		</tr>
		<tbody class="pick">
		<?php
		$i = 0;
		foreach ($images as $media):
		//debug($media);
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
			<tr id='<?php echo $media['Media']['id'] ?>' <?php echo $class;?>>
				<td class="drag-handle"></td>
				
				<td>
					<?php //echo $media['Element']['image']; 
					
					if ($media['Media']['type']=='jpg' or $media['Media']['type']=='png' or $media['Media']['type']=='gif'){
						 echo  $image->resize("/../media/" . $media['Media']['filename'] , 60, 60, true,array('width'=>'80', 'border'=>'0', 'title' => $media['Media']['filename'], 'alt'=>$media['Media']['filename']));
					
					 }
					?>
				</td>
				<!--
				<td>
					<?php echo $time->niceShort($media['Media']['modified']); ?>
				</td>
				-->						
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
		<h2>Selected Items</h2>
			<table id='selected-items'>
			<thead>
			<tr class="nodrag nodrop">
			<td></td>
			<th>Copy</th>
			<th>Image</th>
			<th class="actions"></th>
			
		</tr>
		</thead>
		<tbody>
		<?php
		$i = 0;
//		debug($selected_images);
		foreach ($selected_images as $media):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
			<tr id='<?php echo $media['Media']['id'] ?>' <?php echo $class;?>>
				<td class="drag-handle"></td>
				<td>
					<?php //echo $media['Element']['image']; 
					 echo   $image->resize("/../media/" . $media['Media']['filename'] , 60, 60, true,array('width'=>'80', 'border'=>'0', 'title' => $media['Media']['filename'], 'alt'=>$media['Media']['filename']));
					?>
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
		<div class="additional save">
			<div>
			<h2>Actions</h2>
			<a class="save-elements-button<?php echo $field_name  ?> button" id='save_to_form' >Save</a>
		</div>
		</div>
</div>	
