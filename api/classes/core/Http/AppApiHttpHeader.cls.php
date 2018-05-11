<?php
namespace Api\Classes\Core\Http;

class AppApiHttpHeader
{
	public  static $isMainViewRequest;
	public  static $isDataInRequest;
	public  static $isHavingApiObj;
	public  $headerContent;
	private $headerRequest;
	private $headerResponse;

	public function __construct()
	{
		return $this->getHeaderFields();
	}//end method __construct

	public function getHeaderRequest()
	{
		return new AppApiHttpHeaderRequest(
			$this->headerRequest
		);
	}//end method 	

	public function getHeaderResponse()
	{
		return new AppApiHttpHeaderResponse(
			$this->headerResponse
		);
	}//end method 

	public function __get($propName)
	{
		if(isset($this->headerContent[$propName])){
			return $this->headerContent[$propName];
		}else{
			return FALSE;
		}//endif
	}//end method __get

	private function getHeaderFields()
	{
		$this->checkIfMainViewRequest();
		$this->checkIfDataIsInRequest();
		$this->checkIfHavingModuleRequest();

		$this->headerContent['REQUEST']  = [];
		$this->headerContent['RESPONSE'] = [];
		$hf = getallheaders();
		$hf = $_SERVER;
		foreach($hf as $key => $currHeadValue){
			$name = $this->normalizeName($key);
			$this->headerContent[$name] = $currHeadValue;
		}//end foreach

		if(self::$isDataInRequest || self::$isHavingApiObj){

			$data 	= file_get_contents("php://input");
			$hf 	= json_decode($data, TRUE);			  
			  
			foreach($hf as $key => $currHeadValue){
				$name = $this->normalizeName($key);
				$this->headerContent['REQUEST'][$name] = $currHeadValue;
			}//end foreach		

		}//endif

		$this->headerRequest  = $this->headerContent['REQUEST'];
		$this->headerResponse = $this->headerContent['RESPONSE'];

		return $this;
	}//end method 

	public function setHeaderResponse()
	{
		$this->headerContent['RESPONSE'] = [];
	}//end method setHeaderResponse

	private function normalizeName($name)
	{
		$remove = array('-','_');
		$res = lcfirst(
			str_replace($remove,'',
				ucwords(strtolower($name),'-')
			));
		return $res;
	}//end method normalizeName

	private function checkIfMainViewRequest()
	{
		$data = file_get_contents("php://input");
		$data = json_decode($data, TRUE);
		$showMainView = (isset($data['showMainView']) && $data['showMainView']);

		self::$isMainViewRequest = ($data === NULL || $showMainView);
		return $this;
	}//end method isRequestInitial
	
	private function checkIfDataIsInRequest()
	{
		$data = file_get_contents("php://input");
		$data = json_decode($data, TRUE);
		self::$isDataInRequest = ($data !== NULL);
		return $this;
	}//end method 
	
	private function checkIfHavingModuleRequest()
	{
		$data = file_get_contents("php://input");
		$data = json_decode($data, TRUE);
		self::$isHavingApiObj = (isset($data['apiObj']) && $data['apiObj'] !== NULL);
		return $this;
	}//end method 

}//end class
