// myckeditor/custom_plugins/my_plugin/dialogs/my_plugin.js:
CKEDITOR.dialog.add( 'tree', function( editor ) {
   return {
      title : 'My IFrame Plugin', minWidth : 390, minHeight : 500,
      contents : [ {
            id : 'tab1', label : '', title : '', expand : true, padding : 0,
            elements : [ {
                   type : 'iframe',
                   src : editor.config.RootPath + 'myCustomDialog.phtml',
                   width : 538, height : 500 
            } ]
      } ]
      , buttons : []   // don't show the default buttons
   };
} );