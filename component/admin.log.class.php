<?php
class clsAdminLog
{

	public function __construct()
	{
		global $conn,$breadcrumb; 

		$breadcrumb->add("Main Page", "index.php");
		$breadcrumb->add("Admin Login Log ", "admin.log.php");
	
	}
	private function __set($name,$value)
	{
		$this->$name= handleData($value);	
	}
	private function getAdminLog($where)
	{
		global $conn,$admin_info;
		
		
		$sql = "SELECT
					`admin_log`.*,`admin`.*
				FROM
					`admin_log`
				LEFT JOIN
					 `admin` 
				ON 
					`admin`.`admin_id` = `admin_log`.`admin_id`
				$where
				ORDER BY `admin_log`.`access_time` DESC";
		$adminLog_rs = $conn->Execute($sql);
		if(!$adminLog_rs)
		{
			showErrorMsg($conn->ErrorMsg());
		}
		
		return $adminLog_rs;
		
	}
	
	function showAdminLog($message,$sort)
	{
		global $conn,$admin_info;
		if($sort!= '')
			{$where.= $this->Sort($sort,'');}
		$adminLog_rs = $this->getAdminLog($where);
		
		$currentPage = $_REQUEST["currentPage"];
		initPage($adminLog_rs, PAGE_SIZE, $currentPage, $pageCount, $totalRecord);
		
		include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/admin.title.inc.php");
		include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/admin.log.php");
		include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/admin.tail.inc.php");
		die();
	}
	function Sort($sort,$message='')
	{
		global $conn,$admin_info;
		
		$a= "where 1=1 ";
		foreach($sort as $k => $v)
		{
			if($v != '')
			{
				if($k == 'admin_id')
				{
					$a.= " and  `admin_log`.`admin_id`= '$v'   ";
				}
				if($k == 'ip')
				{
					$a.= " and  `admin_log`.`ip`= '$v'   ";
				}
				
				if($k == 'username')
				{
					$v = strtolower($v);
					$a.= " and  LOWER(`admin`.`username`) LIKE  '%$v%'  ";
					
				}
			}	
		}
	
		//echo $a;die();
		return $a;
		die();
	}
	
}
