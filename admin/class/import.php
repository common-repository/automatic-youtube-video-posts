<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			import.php
//		Description:
//			This file compiles the import form and performs import upon ajax request.
//		Copyright:
//			Copyright (c) 2021 Ternstyle LLC.
//		License:
//			This software is licensed under the terms of the End User License Agreement (EULA)
//			provided with this software. In the event the EULA is not present with this software
//			or you have not read it, please visit:
//			http://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/license.html
//
////////////////////////////////////////////////////////////////////////////////////////////////////

use ternplugin\TERNPLUGIN_admin as TERNPLUGIN_admin;

/****************************************Commence Script*******************************************/

/*------------------------------------------------------------------------------------------------
	For good measure
------------------------------------------------------------------------------------------------*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*------------------------------------------------------------------------------------------------
	Import
------------------------------------------------------------------------------------------------*/

class AYVPP_import_free extends TERNPLUGIN_admin {

	public $page = 'ayvpp-import-videos';
	static $include = [
		'import_free.php',
	];

	public function __construct() {
		parent::__construct();
	}
	public function actions() {
		parent::actions();
	}
	public function enqueue() {}

}
new AYVPP_import_free();


/****************************************Terminate Script******************************************/
?>
