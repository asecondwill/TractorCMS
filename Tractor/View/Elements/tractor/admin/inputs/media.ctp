<h3><?php echo $field ?></h3>
<?php if (!empty($hint))  echo "<p class='hint'>$hint</p>"; ?>
<?php
	echo $this->Form->input($field, array('type'=> 'hidden'));
?>
<!-- where da jquery go? to the traactor.imageselect.js file, dats where! -->




<!--
	This is the table of images selected.  is initialzeronzed with the images from the input
 -->
<table width="100%" title="<?php echo inflector::camelize($model . '_' .$field) ?>" id='element-table-<?php echo inflector::camelize($model . '_' .$field) ?>' class='element-table' cellpadding="0" cellspacing="0">
<thead>
	<tr><th>&nbsp;</th><th>File</th><th>Filename</th><th>Type</th><th>Size</th><th>Created</th><th>&nbsp;</th></tr>
</thead>
<tbody>
        <?php        
        
       if (!empty($this->request->data)){        
         $selected_medias = explode(",", $this->data[$model][$field]);	         
        }else{
           $selected_medias = array();
        }
        

        foreach($selected_medias as $media_item){  
               
        	$media_item = trim($media_item);
        	if (!empty($media_item)){
        	
        	 
        		echo "<tr id = '{$media_item}'><td class='drag-handle'></td><td>";
	        	        	
	        	$path =  $_SERVER['DOCUMENT_ROOT'] . '/app/webroot/media/'  . trim($media_item);
	        	$parts  = pathinfo($path);

	       
	        	if (trim($parts['extension'])=='jpg' or trim($parts['extension'])=='png' or trim($parts['extension'])=='gif'){
	        	
					echo "<a href='/../media/" . $media_item . "' rel='images' class='single_image'>";
				 	echo   $this->Image->resize("/../media/" . $media_item , 80, 80, true,array('border'=>'0', 'alt'=> $media_item));
				 	echo "</a>";
				}
				else{
				
					echo "<a href='/../media/" . $media_item . "' target='_blank'> " ;
					echo   "<img src='/img/admin/filetypes/{$parts['extension']}.png' alt='{$parts['extension']}'/>";
					echo  '</a>';
				}
	        	
	        	
	        	echo "</td>";
	        	echo "<td>{$media_item}</td>";
	        	echo "<td>{$parts['extension']}</td>";
			
	        	echo "<td>";
	        	echo   $this->Number->toReadableSize(filesize($path)) ;
	        	echo "</td>";
	        	echo "<td>{$this->Time->niceShort(filemtime($path))}</td><td class='nodrag nodrop remove'>-</td></tr>";
	        	
	        	
	        
        	}              	        	
        	        
        }

        ?>
  </tbody>      
</table>

<?php

//$filter['medias'] = $medias;

$filter = array(
	'model' => 	$model,
	'field'	=>	$field,
	'types'	=> 	$type
);


$filter = array(
		'admin'=> true, 
		'controller'=>'media',
		'action'=>'listing',
		'model'=>$model,
		'field'=>$field,
		'types'=>$type
		);

if (!empty($width))$filter['width'] = $width;
if (!empty($width_max))$filter['width_max'] = $width_max;
	
if (!empty($height))$filter['height'] = $height;
if (!empty($height_max))$filter['height_max'] = $height_max;



$url = $this->Html->url($filter);		
		
// Fetch the media
$a = "
$.ajax({dataType:'html', evalScripts:true, success:function (data, textStatus) {
		$('#medias_$field').html(data);
		}, 
		type:'post', 
		url:'$url'
		});
";
$this->Js->buffer($a); 	
?>
<a class="toggler" href='#<?php echo $field ?>_files'>Select Files +</a>
<div style="height:14px;">
	<div style='display:none' id='spinner'>whirl.</div>
</div>

<div class="toggled" class='medias_list' id="<?php echo $field ?>_files"> 
	<div id='medias_<?php echo $field ?>'>
	</div>
</div>

<hr/>

<?php    echo $this->Js->writeBuffer(); ?>
