<?php
/*******************************************************************************************************
*	Powered by tractor CMS. Copyright aSecondSystem.com
*
*	Usage granted for one domain and website.
*
*	Not for resale or distribution or any other use without permission from the authors. 
*
********************************************************************************************************/
/* /app/views/helpers/link.php */

class TractorInputsHelper extends AppHelper {
	var $helpers = array('Html', 'Form', 'Js');


	
	
	 function selectOrderImages($field_name, $selected, $content_type){
    	$this->Js->link(array('jquery.js'), false);
		$this->Js->link(array('../jquery.fancybox/jquery.fancybox.js'), false);
		
		$this->Js->link(array('jquery.tablednd_0_5.js'), false);
		
		echo $this->Html->css('/../jquery.fancybox/jquery.fancybox', 'stylesheet', array("media"=>"all" ));    
		
		$s ="
<script type=\"text/javascript\">
$(document).ready(function() {


 $(\"a.fancybox\").fancybox({	
		'hideOnContentClick': false, 
		'frameWidth' : 900, 
		'padding' : 30
	});
$('body').click(function(e) {
	var target = $(e.target);
		if (target.hasClass('save-elements-button$field_name')){			
			var \$items  = '';
			var \$table = $('#selected-items');
			 var rows = \$table.find('tbody > tr').get();
			 $('#Content$field_name').val('');
			 $.each(rows, function(index, row) {
				$('#Content$field_name').val($('#Content$field_name').val() + ',' + $(row).attr('id'));	
				\$items += ',' + $(row).attr('id');
	          });	
			
			$('#selector-link-$field_name').html('<a title=\"Select a Elements\" alt=\"Find\" href=\"/admin/media/pick/$content_type/$field_name/' + \$items + '\" class=\"fancybox\">Choose Images ($content_type)</a>');
			
			$(\"a.fancybox\").fancybox({	
		'hideOnContentClick': false, 
		'frameWidth' : 900, 
		'padding' : 30
	});
			
		 	$('#fancy_close').trigger('click'); 
		 	
		 	
		}
	});	

});
</script>";
    
    
		  $s .=  $this->Form->input($field_name, array('label' =>"Images <small id='selector-link-$field_name'><a title='Select a Elements' alt='Find' href='/admin/media/pick/$content_type/$field_name/$selected' class='fancybox'>Choose Images (" . $content_type . "'s)</a></small>"));
		$s .= "<div id='" . $field_name .  "Preview'>\n";
		$s .= "</div>";
		return $this->output($s);		
    }
    
	
	
	 function selectOrderPages($field_name, $selected, $content_type){
    	$this->Javascript->link(array('jquery.js'), false);
		$this->Javascript->link(array('../jquery.fancybox/jquery.fancybox.js'), false);
		
		$this->Javascript->link(array('jquery.tablednd_0_5.js'), false);
		
		echo $this->Html->css('/../jquery.fancybox/jquery.fancybox', 'stylesheet', array("media"=>"all" ), false);    
		
		$s ="
<script type=\"text/javascript\">
$(document).ready(function() {


 $(\"a.fancybox\").fancybox({	
		'hideOnContentClick': false, 
		'frameWidth' : 900, 
		'padding' : 30
	});
$('body').click(function(e) {
	var target = $(e.target);
		if (target.hasClass('save-elements-button$field_name')){			
			var \$items  = '';
			var \$table = $('#selected-items');
			 var rows = \$table.find('tbody > tr').get();
			 $('#Content$field_name').val('');
			 $.each(rows, function(index, row) {
				$('#Content$field_name').val($('#Content$field_name').val() + ',' + $(row).attr('id'));	
				\$items += ',' + $(row).attr('id');
	          });	
			
			$('#selector-link-$field_name').html('<a title=\"Select a Elements\" alt=\"Find\" href=\"/admin/contents/pick/$content_type/$field_name/' + \$items + '\" class=\"fancybox\">Choose Pages</a>');
			
			$(\"a.fancybox\").fancybox({	
		'hideOnContentClick': false, 
		'frameWidth' : 900, 
		'padding' : 30
	});
			
		 	$('#fancy_close').trigger('click'); 
		 	
		 	
		}
	});	

});
</script>";
    
    
		  $s .=  $this->Form->input($field_name, array('label' =>"Related Navigation Items <small id='selector-link-$field_name'><a title='Select  pages' alt='Find' href='/admin/contents/pick/$content_type/$field_name/$selected' class='fancybox'>Choose pages to link to</a></small>"));
		$s .= "<div id='" . $field_name .  "Preview'>\n";
		$s .= "</div>";
		return $this->output($s);		
    }

	
    function selectOrderElements($field_name, $element_type, $selected){
    	$this->Javascript->link(array('jquery.js'), false);
		$this->Javascript->link(array('../jquery.fancybox/jquery.fancybox.js'), false);
		
		$this->Javascript->link(array('jquery.tablednd_0_5.js'), false);
		
		echo $this->Html->css('/../jquery.fancybox/jquery.fancybox', 'stylesheet', array("media"=>"all" ), false);    
		
		$s ="
<script type=\"text/javascript\">
$(document).ready(function() {
 $(\"a.fancybox\").fancybox({	
		'hideOnContentClick': false, 
		'frameWidth' : 900, 
		'padding' : 30
	});
$('body').click(function(e) {
	var target = $(e.target);
		if (target.hasClass('save-elements-button$field_name')){			
			var \$items  = '';
			var \$table = $('#selected-items');
			 var rows = \$table.find('tbody > tr').get();
			 $('#Content$field_name').val('');
			 $.each(rows, function(index, row) {
				$('#Content$field_name').val($('#Content$field_name').val() + ',' + $(row).attr('id'));	
				\$items += ',' + $(row).attr('id');
	          });				
			$('#selector-link-$field_name').html('<a title=\"Select a Elements\" alt=\"Find\" href=\"/admin/elements/pick/$element_type/$field_name/' + \$items + '\" class=\"fancybox\">Choose $field_name</a>');
			$(\"a.fancybox\").fancybox({	
		'hideOnContentClick': false, 
		'frameWidth' : 900, 
		'padding' : 30
	});
		 	$('#fancy_close').trigger('click');  	
		}
	});	

});
</script>";
		  $s .=  $this->Form->input($field_name, array('label' =>"$field_name <small id='selector-link-$field_name'><a title='Select a Elements' alt='Find' href='/admin/elements/pick/$element_type/$field_name/$selected' class='fancybox'><img alt='Choose $field_name' src='/img/magnifier.png'/></a></small>"));
		$s .= "<div id='" . $field_name .  "Preview'>\n";
		$s .= "</div>";
		return $this->output($s);		
    }
    
    
    function selectImage($image, $type, $field_name, $data_type = 'Content', $label='Image') {
    /*
    	dev notes.  this is a nightmare because cake changing case and whatever other convention stuff its doing to the fieldname id's  , form names, etc.   
    */
   // $field_name =ucwords($field_name);
   $field_name_caked = ucwords($field_name);
	$this->Javascript->link(array('jquery.js'), false);
	$this->Javascript->link(array('../jquery.fancybox/jquery.fancybox.js'), false);
	echo $this->Html->css('/../jquery.fancybox/jquery.fancybox', 'stylesheet', array("media"=>"all" ), false);    
$s ="
<script type=\"text/javascript\">
$(document).ready(function() {
 $(\"a.fancybox\").fancybox({
		'hideOnContentClick': false, 
		'frameWidth' : 900, 
		'padding' : 30
	});
	
$('body').click(function(e) {
	var target = $(e.target).parent();
		if (target.hasClass('media-item-$field_name')){			
			$('#$data_type$field_name_caked').val(target.attr('id'));
			$('#" . $field_name ."ImagePreview').html(\"<img alt='preview' width='80px' src='/media/\" + target.attr('id') + \"'/>\");
			 $('#fancy_close').trigger('click'); 
		}
	});	

});
</script>";
    
    
    
        $s .=  $this->Form->input($data_type."." . ( $field_name), array('label' => $label .  " <small><a title='Select an Image' alt='Find' href='/admin/media/pick_image/$type/$field_name/?height=200&width=700' class='fancybox'>Choose Image</a></small>"));
		$s .= "<div id='" . $field_name . "ImagePreview'>";
		if (isset($image)){
			$s .= "<img width='60px' src='/media/" . $image . "' alt='preview' />";
		}
		$s .= "</div>";
		return $this->output($s);	
    }
    
}
?>