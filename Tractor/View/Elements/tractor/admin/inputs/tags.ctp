<script language="javascript">
	    $(function () {
			$("#<?php echo $id ?>").tagsInput({
				'autocomplete_url': '/admin/tags/tags/list',
				 'autocomplete': { 				 
				 	//option: value, option: value
				 	selectFirst:true,width:'100px',autoFill:true,				 				 	
				 	},
			}); 
		});
</script>


	<?php    		
		echo $this->Form->input('tags', array('type'=>'text'));

    ?>	
