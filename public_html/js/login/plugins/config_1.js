/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	 config.height = 500;
	// config.uiColor = '#AADC6E';
       // config.toolbar= [
	//	{ name: 'basicstyles', items: [ 'Bold', 'Italic','Underline' ] },
        //        [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] 
       // ]
        
};
CKEDITOR.on("instanceReady",function() {
  // insert code to run after editor is ready
  
  $.unblockUI(window);
});


