<?php
$this->Paginator->options(array(
    'update' => "#medias_{$field}",
    'evalScripts' => true,
    'before' => $this->Js->get('#spinner')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#spinner')->effect('fadeOut', array('buffer' => false)),    
    )
);

	
//debug($this->Paginator->options);

?>

<table width="100%" cellpadding="0" cellspacing="0">
<tr>	
	<th><?php echo $this->Paginator->sort('File', 'filename');?></th>
	<th><?php echo $this->Paginator->sort('File Name', 'filename');?></th>
	<th><?php echo $this->Paginator->sort('type');?></th>
	<th><?php echo $this->Paginator->sort('size');?></th>
	
	<th><?php echo $this->Paginator->sort('width');?></th>
	<th><?php echo $this->Paginator->sort('height');?></th>
	<th><?php echo $this->Paginator->sort('created');?></th>
	<th class="actions"></th>
</tr>
<?php
$i = 0;
foreach ($medias as $media):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		
		<td>
			<?php 
			if ($media['Media']['type']=='jpg' or $media['Media']['type']=='png' or $media['Media']['type']=='gif'){
			echo "<a href='/../media/" . $media['Media']['filename'] . "' rel='images' class='single_image'>";
			 echo   $this->Image->resize("/../media/" . $media['Media']['filename'] , 80, 80, true,array('border'=>'0', 'alt'=> $media['Media']['filename']));
			 echo "</a>";
			}
			else{
			
				echo "<a href='/../media/" . $media['Media']['filename'] . "' target='_blank'> ";
			
			echo   "<img src='/img/admin/filetypes/{$media['Media']['type']}.png' alt='{$media['Media']['type']}'/>";

			echo '</a>';
			}
			?>
		</td>
		<td>
			<?php echo  $this->element('media/filename', array('max'=>30, 'filename' => $media['Media']['filename'] )); ?>
		</td>
		<td>
			<?php echo $media['Media']['type']; ?>
		</td>
		<td>
			<?php echo $this->Number->toReadableSize($media['Media']['size']); ?>
		</td>
		<td>
			<?php  echo $media['Media']['width'] ?  $media['Media']['width'] : "n/a"; ?>
		</td>
		<td>
			<?php  echo $media['Media']['width'] ?  $media['Media']['height'] : "n/a"; ?>
		</td>
		<td>
			<?php echo $this->Time->niceShort($media['Media']['created']); ?>
		</td>
		
		<td title='element-table-<?php echo inflector::camelize($model . '_' .$field) ?>' class="add">
			+
		
			<div class="shh">
				<table>
	<?php 			
		echo "<tr class='sneak' id = '{$media['Media']['filename']}'><td class='drag-handle'></td><td>";	   
		          	
		if ($media['Media']['type']=='jpg' or $media['Media']['type']=='png' or $media['Media']['type']=='gif'){
			 echo "<a   href='/../media/" . $media['Media']['filename'] . "' rel='images' class='single_image'>";
			 echo   $this->Image->resize("/../media/" . $media['Media']['filename'] , 80, 80, true,array('border'=>'0', 'title'=>'double click for preview', 'alt'=> $media['Media']['filename']));
			 echo "</a>";
		}else{					
			echo "<a href='/../media/" . $media['Media']['filename'] . "' target='_blank'> ";
			
			echo   "<img src='/img/admin/filetypes/{$media['Media']['type']}.png' alt='{$media['Media']['type']}'/>";

			echo '</a>';
		}	        		        	
		
		echo "</td><td>{$media['Media']['filename']}</td><td>{$media['Media']['type']}</td><td>{$this->Number->toReadableSize($media['Media']['size'])}</td><td>{$this->Time->niceShort($media['Media']['created'])}</td><td class='nodrag nodrop remove'>-</td></tr>";					
	?>			
				</table>	
			</div>	
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

<?php    echo $this->Js->writeBuffer(); ?>