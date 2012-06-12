/*
Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	
	config.uiColor = '#eef3f4';
	config.width = '550'; 
	config.filebrowserBrowseUrl = '/ckeditor/filemanager/index.html';
	config.filebrowserImageBrowseUrl = '/ckeditor/filemanager/index.html?type=Images';
	config.filebrowserFlashBrowseUrl = '/ckeditor/filemanager/index.html?type=Flash';
	config.filebrowserUploadUrl = '/ckeditor/filemanager/connectors/php/filemanager.php';
	config.filebrowserImageUploadUrl = '/ckeditor/filemanager/connectors/php/filemanager.php?command=QuickUpload&type;=Images';
	config.filebrowserFlashUploadUrl = '/ckeditor/filemanager/connectors/php/filemanager.php?command=QuickUpload&type;=Flash'; 	
	config.toolbar_Full =
	[
	    ['PasteFromWord'],
	   	['tree','Link', 'Anchor', 'Unlink','Image','Table'],
	   	['Format','FontSize'],
	    ['Bold','Italic','Underline','-','Subscript','Superscript','Strike'],	    
	    ['TextColor','BGColor','-', 'SpecialChar'],
	    ['Find','Replace'],
	    ['NumberedList','BulletedList','Blockquote'],
	    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
	    ['Maximize', 'ShowBlocks','Source']
	        
	];
	config.extraPlugins='tree';
	
};