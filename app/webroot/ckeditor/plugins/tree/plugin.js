CKEDITOR.plugins.add('tree',{
    requires: ['iframedialog'],
    init:function(editor){
   
    	
        CKEDITOR.dialog.addIframe('tree_dialog', 'Content Tree', this.path + '../../../admin/contents/editor',650,400,function(){
        
        /*oniframeload*/

        })

        var cmd = editor.addCommand('tree', {exec:tree_onclick})
        cmd.modes={wysiwyg:1,source:1}
        cmd.canUndo=false
        editor.ui.addButton('tree',{ label:'Go ahead, pick a page...', command:'tree', icon:this.path+'tree.png' })
    }
})

function tree_onclick(editor)
{
	

    editor.openDialog('tree_dialog');
            
}

//this.path = http://hunter.r4/ckeditor/plugins/tree/
// this works - this.path + 'dialogs/tree.html'
//// ckeditor/plugins/tree

// root - this.path . '../../../admin/content/tree'
