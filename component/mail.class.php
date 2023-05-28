<?php
/*****************sample use this class***********
include_once(ROOT_DIR . "component/mail.class.php");
$mail = new clsEmail();
$mail->variable = array('group_name' => $group_name
						 ,'name' => $name
						 ,'family' => $family
						 ,'username' => $username
						 ,'password' => $password);

$email_html = $pars->send_email('invoice.email.php');
$subject = "Profile $group_name Internet service";
sendmail($email,$subject,$email_html ,"");	*/
//**********************************************************************					
class clsEmail
{
	public $variable;

  
	public function parse()
	{
		$filename = func_get_args();

		ob_start();
		$variable = $this->variable;
		
		//invoice malekloo includ mikoni man bayad ye sfe vase msi be u bedam 
		//function invoice mail malekloo ra seda mizanam member_id va invoicce id midam 
		include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/mail.class.php");
		$email_html = ob_get_contents();
		ob_clean();
		flush();	
		return $email_html;
	}
}
