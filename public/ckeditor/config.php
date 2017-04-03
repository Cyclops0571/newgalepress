<?php
/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

/*
echo "
CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	 config.language = 'tr';
	// config.uiColor = '#AADC6E';\r\n";

if(strpos($_SERVER["REQUEST_URI"], "statictextdetail") == true){
	echo "config.enterMode = CKEDITOR.ENTER_BR;\r\n";
}
	
echo "};";

*/
?>
CKEDITOR.editorConfig = function( config )
{
	//config.resize_enabled = false;
	//config.resize_minWidth = 550;
    config.width = 550;
	config.toolbar = 'Basic';
    config.toolbar_Basic =
    [
        ['Source', 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList']
    ];
};
