<?php
/*
	Related content Selector. 
	Filter. 
	Args:
	$field - field name eg featured_events
	$instruction - eg Choose 4
	$class_name  - class_name  for content type. 
	
	usage:
	================================================================================================
	echo $this->element('tractor/admin/inputs/related', array(
														'hint'=>"Choose 4 related Events", 
														'class_name'=>'events', 
														'field'=>'featured_events'
													));
	var $hasAndBelongsToMany = array(
		
		'Featured' => array(
			'className' => 'Content',
			'joinTable' => 'content_featured',
			'foreignKey' => 'content_id',
			'associationForeignKey' => 'featured_id',
			'unique' => true,
			'order' => 'ContentFeatured.id',

		)
	);												
	============================================================================================
*/

if (empty($class_name)) $class_name = 'all';
if (empty($allowed_class_names)) $allowed_class_names = 'any';

?>
<?php echo $this->Html->script(array( 'jquery.tablednd_0_5')); ?>
<script>
  function additem($id, $title){	
        $("#element-table").append("<tr><td class='drag-handle'></td><td>" + $title + "<input type='hidden' name='data[Featured][Featured][]' value='" + $id + "'></td><td class='nodrag nodrop remove'>-</td></tr>");				
	    $("#element-table").tableDnD({ dragHandle: "drag-handle"})
	}
</script>
<?php
  $a = "
    // Initialise the table
    $('#element-table').tableDnD({ })    
    $('.remove').live('click', function(event) {
        $(this).parent().remove();
        });    
     $('#search_content').keyup(function() {     	
        $('.pick_from').load('/admin/contents/tree/$class_name/$allowed_class_names/' + $('#search_content').val());
    })
    .change();
";
$this->Js->buffer($a);
?>    


<label><?php echo Inflector::humanize($field) ?></label>    
<p class="hint"><?php echo $hint ?></p>
<div class="complex_field">		
	<div class="grid_4 alpha">
		<h4>Choose Content  <input id='search_content' name='search_content'/> <small>(Filter)</small> </h4>
		<?php
		$a = "
		$.ajax({dataType:'html', evalScripts:true, success:function (data, textStatus) {
				$('#contents_list').html(data);
				}, 
				type:'post', 
				url:'\/admin\/contents\/tree/$class_name/$allowed_class_names'
				});
		";
		?>
			<div id='contents_list'>
				
			</div>
		<?php echo $this->Js->buffer($a); 	?>
	</div>
	
	
	
	<div class="grid_3 omega">
		<h4>Selected Content</h4>
		<p class="hint">Drag the handles to order</p>
		<table id='element-table' cellpadding="0" cellspacing="0">
		        <?php
		        foreach($this->request->data['Featured'] as $content){
		        	echo "<tr><td class='drag-handle'></td><td>" . $content['title']   . "<input type='hidden' name='data[Featured][Featured][]' value='" . $content['id'] . "'></td><td class='nodrag nodrop remove'>-</td></tr>";
		        }
		        ?>
		</table>
	</div>
</div>
<br class="clear"/>