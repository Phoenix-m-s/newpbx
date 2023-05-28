<?php
class Main
{
	//private $_notification;
	function Main()
	{
		global $breadcrumb;

		$breadcrumb->add("Management", "index.php");
		//$this->_notification = array();	
	}

	function showForm($message = '')
	{
		global $conn, $admin_info;

		include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/admin.title.inc.php");
		include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/admin.rightMenu.php");
		include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/admin.index.php");
		include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/admin.tail.inc.php");

		die();
	}
}