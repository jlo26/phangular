<?php
namespace Api\Classes\Core;
use Api\Classes\Core\Http as AppCoreHttp;

class AppApiRequest
{

	CONST DEFAULT_API_NS        = "Api\Src";
	CONST DEFAULT_API_OBJ 		= 'AppMainController';
	CONST DEFAULT_API_MOD 		= 'AppMain';
	CONST DEFAULT_API_METHOD	= 'indexCtrl';	
	CONST DEFAULT_API_MOD_NS    = "Api\Modules";

	private $isMainViewRequest;
	private $isDataInRequest;
	private $isHavingApiObj;
	private $apiModuleName;
	private $apiObj;
	private $apiObjMethod;
	private $apiObjData;
	private $apiShowUI;
	private $jwtToken;
	private $csrfToken;
	private $parameter;

	private $httpHeadObj;
	public function __construct(AppCoreHttp\AppApiHttpHeader $httpHead)
	{
		$reqObj 					= $httpHead->getHeaderRequest();
		$this->httpHeadObj 			= $httpHead;
		$this->isMainViewRequest 	= AppCoreHttp\AppApiHttpHeader::$isMainViewRequest;
		$this->isDataInRequest 		= AppCoreHttp\AppApiHttpHeader::$isDataInRequest;

		if($this->isDataInRequest || $this->isHavingApiObj){
			
			$this->apiModuleName = $reqObj->apiobj;
			$ctrlName 			 = $reqObj->apiobj.'Controller';
			$srcNS				 = (
				$this->apiModuleName == self::DEFAULT_API_MOD
			)? self::DEFAULT_API_NS : self::DEFAULT_API_MOD_NS;

			$this->apiObj 		 = $srcNS.NSEP.$this->apiObj;
			$this->apiObjMethod	 = $reqObj->apiobjmethod;
			$this->apiObjData 	 = $reqObj->apiobjdata;
			$this->apiShowUI 	 = $reqObj->apishowui;
			$this->jwtToken 	 = $reqObj->jwttoken;
			$this->csrfToken 	 = $reqObj->csrftoken;
			$this->parameter 	 = $this->apiObjData;

		}else{

			$this->apiModuleName = self::DEFAULT_API_MOD;
			$this->apiObj 		 = self::DEFAULT_API_NS.NSEP.self::DEFAULT_API_OBJ;
			$this->apiObjMethod	 = self::DEFAULT_API_METHOD;
			$this->apiObjData 	 = [];
			$this->apiShowUI 	 = FALSE;
			$this->jwtToken 	 = '';
			$this->csrfToken 	 = '';
			$this->parameter 	 = [];
			
		}//endif

		return $this;
	}//end method __construct

	public function __call($fxName,$val)
	{
		$operation = substr($fxName,0,3);
		$fxName    = substr($fxName,3);
		$propName  = lcfirst($fxName);
		if(property_exists($this, $propName)){
			if(strtolower(trim($operation)) == 'set'){
				$this->$propName = $val;
				return $this;
			}else{
				return $this->$propName;
			}//endif
		}//end if
	}//end method
	
	public function authCredentialsExists()
	{
		return (
			!is_null(trim($this->jwtToken)) &&  
			!is_null(trim($this->csrfToken))
		);
	}//end method 

	
}//end class
