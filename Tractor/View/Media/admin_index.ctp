<?php
$this->Html->script(array('uploadify.js','swfobject.js'), false);
echo $this->Html->css('uploadify', 'stylesheet', array("media"=>"all" ));
echo $this->Html->css('/../jquery.fancybox/jquery.fancybox', 'stylesheet', array("media"=>"all" ));
?>

<script type="text/javascript">// <![CDATA[
$(document).ready(function() {
 
 $("a#single_image").fancybox();
 
var path = "<?= $this->Html->url("/app/webroot/uploadify/")?>";
$('#fileInput').uploadify({
'scriptData': { 'sessionID': 'bob'},
'what'      : 'two', 
'uploader'  : path + '/uploadify.swf',
'script'    : '/media/upload/<?= $session_id ?>',
'cancelImg' : path + '/cancel.png',
'auto'      : true,
'folder'    : '/media',
'multi'     : true,
'auto'      : true,
 'onAllComplete': function(event, data) {
        location.reload(); 
      },
'onError' : function(event, queueID, fileObj, errorObj) { alert(errorObj.type + ' ' + errorObj.info  ); }
});
});
// ]]></script>

<div class="contents">
<div class='content-item grid_9 alpha' >
<h2><?php echo __('Media');?></h2>
<table cellpadding="0" cellspacing="0">
<tr>	
	<th><?php echo $this->Paginator->sort('File', 'filename');?></th>
	<th><?php echo $this->Paginator->sort('File Name', 'filename');?></th>
	<th><?php echo $this->Paginator->sort('type');?></th>
	<th><?php echo $this->Paginator->sort('size');?></th>
	<th><?php echo $this->Paginator->sort('created');?></th>
	<th><?php echo $this->Paginator->sort('modified');?></th>
	<th class="actions"><?php echo __('Actions');?></th>
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
			echo "<a href='/../media/" . $media['Media']['filename'] . "' rel='images' id='single_image'>";
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
			<?php echo $media['Media']['filename']; ?>
		</td>
		<td>
			<?php echo $media['Media']['type']; ?>
		</td>
		<td>
			<?php echo $this->Number->toReadableSize($media['Media']['size']); ?>
		</td>
		
		<td>
			<?php echo $this->Time->niceShort($media['Media']['created']); ?>
		</td>
		<td>
			<?php echo $this->Time->niceShort($media['Media']['modified']); ?>
		</td>
		<td class="actions">
				<?php 
				//	echo $this->Html->image('admin/application_edit.png',  array('alt' => 'edit',  'url' => array('action' => 'edit', $media['Media']['id'])));
					
			
?>
					<?php echo $this->Html->link($this->Html->image('admin/trash.gif'), array('action' => 'delete', $media['Media']['id']), array('escape'=>false), sprintf(__('Are you sure you want to delete # %s?'), $media['Media']['filename']), array('class'=>'delete')); ?>
			
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
</div></div>
<div class="additional grid_3 omega">
		<div>
			<h2>Add Media</h2>	
			<div class='form-wrap'>
<p><input id="fileInput" name="fileInput" type="file" /></p>
<p>Browse to your files to upload them to the media manager. </p>
<p> You Can't select folders, but you can select more than one file at once.</p>

</div>
</div>
</div>