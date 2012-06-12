$(document).ready(function() { 
		$('.toggled').hide();
				
				$('.toggler').click(function() {
						
				  var strFiles =  $(this).attr('href');
				 
				  $(strFiles).slideToggle();
				});	   


	//chnage to class and move all this into a file will
	$(".element-table").tableDnD({    
		onDrop: function(table, row) {
            var rows = table.tBodies[0].rows;
            answer = '';                       
            for (var i=0; i<rows.length; i++) {
                answer += rows[i].id+",";
            }
	        $('#' + $(table).attr("title")).val(answer);
	    }
	});


	$("td.remove").live('click', function(event) {
		var element  = this;
		
		var table  = $(this).parents('table').attr("id");
		
		
		$(this).parent().remove();
		
		var rows  = $('#'+table).attr("rows");
		
	  
	  	answer = '';                       
		for (var i=0; i<rows.length; i++) {
		    answer += rows[i].id+",";
		}
			
		inputId = $('#'+table).attr("title");
		$('#'+inputId).val(answer);
	  
	});

	$("td.add").live('click', function(event) {
		var tableId = $(this).attr('title');
		var row = $(this).find(".shh table tbody");
		
		$('#'+tableId).append(row.html());
	
		var rows  = $('#'+tableId).attr("rows");
		  
	  	answer = '';                       
		for (var i=0; i<rows.length; i++) {
		    answer += rows[i].id+",";
		}
			
		inputId = $('#'+tableId).attr("title");
		$('#'+inputId).val(answer);
		
		$("#"+tableId).tableDnD({    
		onDrop: function(table, row) {
	            var rows = table.tBodies[0].rows;
	            answer = '';                       
	            for (var i=0; i<rows.length; i++) {
	                answer += rows[i].id+",";
	            }
		        $('#' + $(table).attr("title")).val(answer);
		    }
		});

	});

 
	$("a.single_image").live("click",function(e){		
		
	    e.stopPropagation();			
		$(this).fancybox()		
		e.preventDefault();
	});


 });