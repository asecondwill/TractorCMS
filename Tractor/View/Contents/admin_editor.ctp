<!html>
<script src='/js/jquery.js' ></script>
<script>
$(document).ready(function () {
    // Initialise the table
				
	//When page loads...
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content

	//On Click Event
	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});
});


	var CKEDITOR = window.parent.CKEDITOR;	
	
	
	var okListener = function(ev) {
		console.log(CKEDITOR.instances);	
//		var selected_html = CKEDITOR.instances.editor1.getSelection().getSelectedText(); 
//		alert(selected_html)
			
		content_id = $('input:radio[name=content_id]:checked').val();
		console.log(content_id);
		
		title = document.getElementById('title_' + content_id).value;
		
		
		classes = document.getElementById('classes').value;		
		if(classes) {
			classes = " class='" + classes + "' ";
		}
		
		target = document.getElementById('target').value;
		if(target) {
			target = " target='" + target + "' ";
		}
		

		
		selectedText  = this._.editor.getSelection();		
		
		
		
	   this._.editor.insertHtml('<a href="[t:url id=' + content_id + ']' + classes + target + '">' +  title + '</a>');

	   CKEDITOR.dialog.getCurrent().removeListener("ok", okListener);
	};
	
	CKEDITOR.dialog.getCurrent().on("ok", okListener);	
</script>

<style>
	html.tree{
		color: #333; font-family: Helvetica, sans-serif; font-size: 11px;
	}
	ul{
		list-style: none; padding-left: 10px; height: 350px;
	}
	ul li{
		padding-bottom: 5px;
	}
	ul li a:link, ul li a:visited{
		text-decoration: none; color: #333
	}
	ul li a:hover{
		text-decoration: underline
	}
	html.tree{
		height: 350px;
	}
	label {
		display: block
	}
	
	/*tabs*/
ul.tabs {
	margin: 0;
	padding: 0;
	float: left;
	list-style: none;
	height: 32px; /*--Set height of tabs--*/
	border-bottom: 1px solid #999;
	border-left: 1px solid #999;
	width: 100%;
}
ul.tabs li {
	float: left;
	margin: 0;
	padding: 0;
	height: 31px; /*--Subtract 1px from the height of the unordered list--*/
	line-height: 31px; /*--Vertically aligns the text within the tab--*/
	border: 1px solid #999;
	border-left: none;
	margin-bottom: -1px; /*--Pull the list item down 1px--*/
	overflow: hidden;
	position: relative;
	background: #e0e0e0;
}
ul.tabs li a {
	text-decoration: none;
	color: #000;
	display: block;
	font-size: 1.0em;
	padding: 0 20px;
	border: 1px solid #fff; /*--Gives the bevel look with a 1px white border inside the list item--*/
	outline: none;
}
ul.tabs li a:hover {
	background: #ccc;
}
html ul.tabs li.active, html ul.tabs li.active a:hover  { 
	background: #fff;
	border-bottom: 1px solid #fff; 
}

.tab_container {
	border: 1px solid #999;
	border-top: none;
	overflow: hidden;
	clear: both;
	float: left; width: 100%;
	background: #fff;
}
.tab_content {
	padding: 20px;
	font-size: 1.2em;
	height: 300px; overflow: auto;
}

</style>

<html class='tree'>
	<body>
	<ul class="tabs">
    <li><a href="#tab1">Link</a></li>
    <li><a href="#tab2">Advanced</a></li>   
</ul>
<form name="form1">
<div class="tab_container">
    <div id="tab1" class="tab_content">
		<ul>
			<?php 
				foreach ($content_tree as $content){
					echo "<li>
							<input type='hidden' name='title_{$content['Content']['id']}' id='title_{$content['Content']['id']}'  value=\"{$content['Content']['title']}\" />
							<label  >
								
								<input type='radio'  name='content_id' id='content_id' value='{$content['Content']['id']}'/> &nbsp; "
								 . str_repeat("--", $content['Content']['depth']-1)  .  "{$content['Content']['title']}
							</label>
						</li>";	
				}
			?>
		</ul>
	</div>
	<div id="tab2" class="tab_content">
		<p>
			<label for='classes'>Classes</label>
			<input name='classes'  id='classes'/><br/>
			<span class="hint">As many as you like, seperated with a space</span>
		</p>	
		
		<p>
			<label for='target'>Target</label>
			<input name='target' id='target' /><br/>
			<span class="hint">Specifies the window, eg _blank for new window</span>
		</p>	
	</div>
</div>	
</form>
	</body>
</html>

<?php
/*
foreach ($content_tree as $content){
	$json[] = array($content['Content']['title'], "[t:link id={$content['Content']['id']}]");	
}


echo json_encode ($json);
*/
?>
