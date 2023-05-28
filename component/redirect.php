<?php
/**
* Redirect Process Message
*
* @author    Ahmad Reza Mansouri <ahmadreza@city-telecom.com>
*/


/*
*USAGE Sample
*	
*	include_once(ROOT_DIR . "component/redirect.php");
*	$redirect = new redirect();
*	//Fallow the below rules in the case of Set Message : :
*	$redirect->_setMessageToSession(Message	  = "Test Message"
									,Type	  = (1 //SUCCESSFULL// ,0 //WARNINGS// , -1//ERROR)
									,Function = "Function Name"
									,Class	  = "Class Name"
									,Line	= "105"
									)
*	
*	//Fallow the below rules in the case of retrive message :
*	$redirect->_retrieveMessage();//Return array("Message"=>"SUCCESSFULL","Type"=>"1","Function"=>"","Class"=>"","Line"=>"")
*	
*	//Fallow the below rules in the case of Remove Message :
*	$redirect->_removeMessage();
*
*
*	//ّFallow the below rules in the case of Show Message :
*	
|***********************************************************************************************************************************|              
				<style>
				.processLog{
					min-width: 500px;
					height:auto;
					border: 2px dashed  #749926;
					background-color:#FFF;
					padding:10px 10px;
					font-family:"Courier New", Courier, monospace;
				}
				.processLog img{
					right:-1px;
					position:absolute;
				}
				.dottedMessage{
					background:url(<?=TEMPLATE_DIR?>images/dot.png) repeat-x 0 7px;
					width:100%;
					display:inline-block;
					position:relative;
				}
				.whiteMessage{
					background:#FFF;
					float:left;
				}
				</style>
				
				<div class="processLog">
	
					<?php
                    $retriveMessage = $redirect->_retrieveMessage();
                    foreach($retriveMessage as $NO=>$RedirectMessage)
                    {
                        echo "<div class='dottedMessage'><div class='whiteMessage'>".$RedirectMessage['Message']."</div>";
						if($RedirectMessage['Type']== "Successfull")
						{
							?>
                            <img src="<?php echo TEMPLATE_DIR."images/Message/Successfull.png" ;?>"  width="15" />
                            <?php
						}
						elseif($RedirectMessage['Type']== "Warning")
						{
							?>
                            <img src="<?php echo TEMPLATE_DIR."images/Message/Warning.png" ;?>" width="15" />
                            <?php
						}
						elseif($RedirectMessage['Type']== "Error")
						{
							?>
                            <img src="<?php echo TEMPLATE_DIR."images/Message/Error.png" ;?>" width="15" />
                            <?php
						}
                        echo "</div><BR>";
                    }	
                    $b = $this->_redirect->_removeMessage();
                    ?>
				</div>
|***********************************************************************************************************************************|              
*
*
*/

class redirectProcessMessage extends getProduct
{
	/**
	* 
	* @param array $message  we use this parameter to save success/error message and give it to session
	* @param string $url  	 we use this parameter to save page url that you want redrect message to  it
	*/
	
	private $_Message;
	private $_URL	 = '';
	
	public function __contruct()
	{
		global $conn;
		
		$this->_Message = array("Message"=>""
								,"Type"=>""
								,"Function"=>""
								,"Class"=>""
								,"Line"=>""
								);
	}
	public function __set($field,$value)
	{
		
		switch ($field) :
			case "_Message" :
				$this->_setMessage($field,$value);
				break;
			case "_URL" :
				$this->_setURL($value);
				break;
			default :
				if(array_key_exists($field,$this->_Message))
				{
					$this->_setMessage($field,$value);
				}
				else
				{
					$this->$field = handleData($value);
				}
		endswitch;
	}
	public function __get($field)
	{
		switch ($field) :
			case "_Message" :
				return $this->_Message;
				break;
			case "_URL" :
				return $this->_URL;
				break;
			default :
				if(array_key_exists($field,$this->_Message))
				{
					return $this->_Message[$field];
				}
				else
				{
					return $this->$field;
				}
		endswitch;
	}
	/**
	* Call
	*
	*@access Public
	*
	*This function get the method name and call it
	*/
	public function __call($Method,$Args)
	{
		switch ($Method) :
			case "_setMessageToSession" :
				$this->_setMessage("_Message",$Args);
				$Result = $this->_setMessageToSession();
				break;
			case "_goToURL" :
				$this->_setURL($Args);
				$Result = $this->_goToURL();
				break;
			case "_retrieveMessage" :
				$Result = $this->_retrieveMessage();
				break;
			case "_removeMessage" :
				$Result = $this->_removeMessage();
				break;
		endswitch;
		
		return $Result;

	}
	/**
	* Set Message 
	*
	*@access Private
	*
	*This function set the _Message Parameter after checking
	*/
	private function _setMessage()
	{
		$temp = func_get_args();
		$variableName  = $temp[0];
		$variableValue = $temp[1];
		
		switch ($variableName) :
			case "_Message" :
				foreach($variableValue as $key=>$val)
				{
					switch ($key) :
						case "0" :
							if(!is_string($val))
							{
								$this->_Message['Message'] = ModelREDIRECT_01;
							}
							else
							{
								$this->_Message['Message'] = $val;
							}
						break;
						case "1" :
							if($val == 1)
							{
								$this->_Message['Type'] = ModelREDIRECT_02;
							}
							elseif($val == 0)
							{
								$this->_Message['Type'] = ModelREDIRECT_03;
							}
							elseif($val == -1)
							{
								$this->_Message['Type'] = ModelREDIRECT_04;
							}
						break;
						case "2" :
							if(!is_string($val))
							{
								$this->_Message['Function'] = ModelREDIRECT_05;
							}
							else
							{
								$this->_Message['Function'] = $val;
							}
						break;
						case "3" :
							if(!is_string($val))
							{
								$this->_Message['Class'] = ModelREDIRECT_06;
							}
							else
							{
								$this->_Message['Class'] = $val;
							}
						break;
						case "4" :
							if(!is_numeric($val))
							{
								$this->_Message['Line'] = ModelREDIRECT_07;
							}
							else
							{
								$this->_Message['Line'] = $val;
							}				
						break;
					endswitch;
				}
			break;
			
			default :
			if(array_key_exists($variableValue,$this->_Message))
			{
				switch ($variableName) :
					case "Message" :
						if(!is_string($val))
						{
							$this->_Message['Message'] = ModelREDIRECT_01;
						}
						else
						{
							$this->_Message['Message'] = $val;
						}
					break;
					case "Type" :
						if($val == 1)
						{
							$this->_Message['Type'] = ModelREDIRECT_02;
						}
						elseif($val == 0)
						{
							$this->_Message['Type'] = ModelREDIRECT_03;
						}
						elseif($val == -1)
						{
							$this->_Message['Type'] = ModelREDIRECT_04;
						}
					break;
					case "Function" :
						if(!is_string($val))
						{
							$this->_Message['Function'] = ModelREDIRECT_05;
						}
						else
						{
							$this->_Message['Function'] = $val;
						}
					break;
					case "Class" :
						if(!is_string($val))
						{
							$this->_Message['Class'] = ModelREDIRECT_06;
						}
						else
						{
							$this->_Message['Class'] = $val;
						}
					break;
					case "Line" :
						if(!is_numeric($val))
						{
							$this->_Message['Line'] = ModelREDIRECT_07;
						}
						else
						{
							$this->_Message['Line'] = $Line;
						}				
					break;
				endswitch;
			}
			break;
		endswitch;
		
	}
	/**
	* Set URL
	*
	*@access private
	*
	*This function set the _URL Parameter after checking
	*/
	private function _setURL()
	{
		$urlValue = func_get_args();
		if(!filter_var($urlValue[0], FILTER_VALIDATE_URL,FILTER_FLAG_QUERY_REQUIRED))
		{
			$this->_URL = RELA_DIR;
		}
		else
		{
			$this->_URL = $urlValue[0];
		}
	}	
	/**
	* Set Message To Session
	*
	*@access Private
	*
	*This function get message from _Message parameter and give it to sesstion
	*/
	private function _setMessageToSession()
	{
		
		if(!isset($_SESSION)) 
		{
    		session_start();
		}
		
		$_SESSION['Message'][] = $this->_Message; 
		return 1;
	}
	/**
	* Go To URL
	*
	*@access Private
	*
	*This function get url from _URL parameter and redrect to it
	*/
	private function _goToURL()
	{
		header("Location : ".$this->_URL);
		die();
	}
	/**
	* Retrive Message
	*
	*@access Private
	*
	*This function retrive message that you want from session
	*/
	private function _retrieveMessage()
	{
		return $_SESSION['Message'];
	}
	/**
	* Remove Message
	*
	*@access Private
	*
	*This function remove message 
	*/
	private function _removeMessage()
	{
		
		unset($_SESSION['Message']);
		unset($this->_Message);
		unset($this->_URL);
		return 1;
		
	}
}
