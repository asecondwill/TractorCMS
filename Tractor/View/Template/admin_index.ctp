<?php echo $this->Html->script('codemirror/codemirror', true);	?>


<div class="contents index">
<div class="content-item alpha grid_8">


<?php

 if(empty($file)){
	?>
	<h2><?php echo __('Templates') ;  ?></h2>

	<?php
	echo "<p>Please Select a file to edit on the right</p>";	
}else{
	?>
	<?php echo $this->Form->create(array('url'=> array('controller'=>'template', 'action'=>'index', $file_pass))); echo "<h2>";  echo __('Template') ; echo " - " . $file; echo "<span class='action'>" . $this->Form->submit('Save Changes');?></span></h2>

	<?php		
	echo $this->Form->textarea('contents',array('value'=>$template_content, 'label'=>'Contents', 'cols'=>60, 'rows'=>'80') );
	

	
	echo $this->Form->end();
}

?>
<hr/>
<P>The editor sports an undo/redo system, accessible with control-z (undo) and control-y (redo). Safari will not allow client scripts to capture control-z presses, but you can use control-backspace instead on that browser.</P>

<p>The key-combination control-[ triggers a paren-blink: If the cursor is directly after a '(', ')', '[', ']', '{', or '}', the editor looks for the matching character, and highlights these characters for a moment. </p>
</div>
</div>

<div class="additional omega grid_4">
	<div>
	<h2>Files</h2>
	<div class="list">
	<?php
		echo $this->Directory->recursive('/app/View/Themed/' . $theme_name, true, array('menu_items', 'site_texts', 'helpers', '.svn' ,  'template', 'vendors', 'admin', 'js', 'rss', 'xml', 'untitled file', '.DS_Store', 'admin_index.ctp', 'admin_add.ctp', 'admin_edit.ctp', 'admin_pick.ctp','admin_delete.ctp','admin_pick_image.ctp', 'letters', 'Informations', 'blocks','contents', 'forum_categories', 'forum_topics','forum_comments','admin.ctp', 'media','admin_view.ctp'));
	?>
</div>
	</div>
</div>	


<script type="text/javascript">
var editor = CodeMirror.fromTextArea('TemplateContents', {
        height: "1550px",
        parserfile: ["parsexml.js", "parsecss.js", "tokenizejavascript.js", "parsejavascript.js",
                     "tokenizephp.js", "parsephp.js",
                     "parsephphtmlmixed.js"],
        stylesheet: ["/css/codemirror/xmlcolors.css", "/css/codemirror/jscolors.css", "/css/codemirror/csscolors.css", "/css/codemirror/phpcolors.css"],
         path: "/js/codemirror/",
        continuousScanning: 500,
         lineNumbers: true,
         autoMatchParens: true,
      });

/*
  var textarea = document.getElementById('TemplateContents');
  var editor = new CodeMirror(CodeMirror.replace(textarea), {
    height: "1750px",
    width: "600px",
    content: textarea.value,
    parserfile: ["tokenizejavascript.js", "parsejavascript.js", "parsexml.js", "parsephp.js", "parsecss.js"],
    stylesheet: ["/css/codemirror/xmlcolors.css","/css/codemirror/phpcolors.css",  "/css/codemirror/phpcolors.css" ],
    path: "/js/codemirror/",
    autoMatchParens: true,
    lineNumbers: true
    
  });
  
  */
</script>
