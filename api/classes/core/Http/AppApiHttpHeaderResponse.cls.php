<?php
namespace Api\Classes\Core\Http;

class AppApiHttpHeaderResponse
{
	private $headerContent;
	public function __construct(array $header)
	{
		return $this->headerContent = $header;
	}//end method __construct

	public function __get($propName)
	{
		if(isset($this->headerContent[$propName])){
			return $this->headerContent[$propName];
		}else{
			return FALSE;
		}//endif
	}//end method __get	
}//end class
