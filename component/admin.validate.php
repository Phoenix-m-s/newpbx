<?php
class clsValidation
{
	private $_method;
	private $_args;
	private $_Result;
	
	public function __construct($internetUser)
	{
		$callFrom = get_class($internetUser);
  		if($callFrom != "clsInternetUsers")
		{
			die('Call From Wrong Class');
		}
		
		$this->_method = "";
		$this->_args   = array();
		$this->_Result = array();
	}
	public function __set($field,$value)
	{
		switch ($field) :
			case "_args" : 
				$this->_set_args($value);
				break;
			default :
				$this->$field = $value;
		endswitch;
	}
	private function _set_method()
	{
		$temp = func_get_args();
		if(method_exists($this,$temp[0]))
		{
			$this->_method = '_'.$temp[0];
		}
		
	}
	private function _set_args()
	{
		$temp = func_get_args();
		if(!empty($temp[0]))
		{
			$this->_args = $temp[0];
			$_Result[0] = 1;
			$_Result['Msg'] = ModelADMIN_83;
			return $_Result; 
			
		}
		else
		{
			$_Result[0] = 0;
			$_Result['errMsg'] = ModelADMIN_84;
			return $_Result;
		}
	}
	public function __call($method,$args)
	{
		$this->_Result = $this->_set_args($args);
		if($this->_Result[0]==1)
		{
			$_Result =  $this->$method();
			return($_Result);
		}
		elseif($this->_Result[0]==0)
		{
			die($this->_Result['errMsg']);
		}
		
	}
	private function validateEmpty()
	{

		if (!empty($this->_args[0]) && ($this->_args[1] =="" || $this->_args[1] =="0"))
		{
			
			
		
			if($this->_args[0]=='INTERNET_OPTION_ID')
			{
				$_Result[0] = 1;
				$_Result['Msg'] = ModelADMIN_85;
				$_Result['value'] = handleData($this->_args[1]);
				return $_Result; 
				die();				

			}	
			if($this->_args[0]=='internet_option')
			{
				$_Result[0] = -1;
				$_Result['Msg'] = ModelADMIN_86;
				$_Result['value'] = handleData($this->_args[1]);
				return $_Result; 
			}
			else
			{
				$_Result[0] = 0;
				$_Result['errMsg'] = $this->_args[0].ModelADMIN_87;
				return $_Result; 
				die();
			}
		}
		elseif (empty($this->_args[0]))
		{
			$_Result[0] = 0;
			$_Result['errMsg'] = ModelADMIN_88;
			return $_Result; 
			die();
		}
		elseif(!empty($this->_args[0]) && $this->_args[1] !="")
		{
			$_Result[0] = 1;
			$_Result['Msg'] = ModelADMIN_85;
			$_Result['value'] = handleData($this->_args[1]);
			return $_Result; 
			die();
		}
	}
	
	
}
