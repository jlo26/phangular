<?php
namespace Api\Classes\Core;
use Api\Src\AppMain as AppMain;
use Api\Classes\Core\Http as AppCoreHttp;

class AppApiCore
{

	public $appRequest;
	public $appResponse;
	public $appApiObj;
	public $appApiMethod;
	public $appApiParam;

	private $authenticated;
	private $authorized;
	private static $defaultApiSrc = [
		"modNameSpace"	=>	'',
		"nameSpace"		=>	'',
		"className"		=>	'',
		"method"		=>	'',
		"param"			=>	'',
	];

	public function __construct()
	{
		$httpHead   = new AppCoreHttp\AppApiHttpHeader();
		$httpReqObj = new AppApiRequest($httpHead);

		$this->appRequest = $httpReqObj;
		self::$defaultApiSrc['modNameSpace']= $httpReqObj::DEFAULT_API_MOD_NS;
		self::$defaultApiSrc['nameSpace'] 	= $httpReqObj::DEFAULT_API_NS;
		self::$defaultApiSrc['className'] 	= $httpReqObj::DEFAULT_API_OBJ;
		self::$defaultApiSrc['method'] 		= $httpReqObj::DEFAULT_API_METHOD;
		self::$defaultApiSrc['param']  		= $httpReqObj->getParameter();

		return $this->authenticate()->authorize();				
	}//end method __construct


	/*
	* @todo Do the actual authentication base from jwt token
	* and csrfToken
	*/
	public function authenticate()
	{
		$res = FALSE;

		if($this->appRequest->authCredentialsExists()){
			/*
			* do the actual authentication by checking the token
			* jwt should be the actual result of authentication
			*/
			$res = TRUE;
		}else{
			$res = FALSE;
		}//end method

		$this->authenticated = $res;
		return $this;
	}//end method authenticate

	/*
	* @todo Do the actual authorization base 
	* from the apiObj requested
	*/
	public function authorize()
	{
		if($this->authenticated){
			/*
			* do the actual authorization by accessing the actual resource
			* res should be the actual result of authentication
			*/
			$this->authorized = TRUE;
		}else{
			$this->authorized = FALSE;
		}//endif
		return $this;
	}//end method authorize

	/*
	* Initialize api object
	*/
	public function route()
	{
		$this->appResponse 	= new AppApiResponse();
		$this->appApiParam  = $this->appRequest->getParameter();
		$className  		= $this->getAppApiObjRequest();

		$this->modelObj 	= new $className['model']($this->appRequest);
		$this->viewObj 		= new $className['view']($this->modelObj,$this->appResponse);

		$this->appApiObj 	= new $className['ctrl'](
			$this->appRequest,
			[ 
				"MODEL" => $this->modelObj,
				"VIEW"	=> $this->viewObj
			]
		);
		$this->appApiMethod = $this->getAppApiObjMethod($this->appApiObj);
		$methodResponse  = $this->executeMethodCall(
			$this->appApiObj,
			$this->appApiMethod,
			$this->appApiParam
		);
		//$this->appResponse->addResponse($methodResponse);
		$this->executeMethodCall(
			$this->appApiObj,
			'beforeResponseSend',
			[$this->appRequest, $methodResponse]
		);
		
		return $this;
	}//end method route

	private function getAppApiObjRequest()
	{
		$moduleName = $this->appRequest->getApiModuleName();
		$apiObjSrc  = $this->appRequest->getApiObj();
		
		if($this->appRequest->getIsDataInRequest() ||  $this->appRequest->getIsHavingApiObj()){
			
			$classPrefix = $apiObjSrc.$moduleName.NSEP.$moduleName;
			$cls  	 	 = $classPrefix."Controller";

			$classNameModel = $classPrefix."Model";
			$classNameView	= $classPrefix."View";
			return [
				"model"	=> $classNameModel,
				"view"	=> $classNameView,
				"ctrl"	=> $cls,
			];

		}else{

			$classPrefix = $ns.NSEP.$moduleName.NSEP.$moduleName;
			$classNameModel = $classPrefix."Model";
			$classNameView	= $classPrefix."View";
			return [
				"model"	=> $classNameModel,
				"view"	=> $classNameView,
				"ctrl"	=> $apiObjCtrl,
			];
		}//endif
	}//end method

	private function getAppApiObjMethod(AppMain\AppMainController $apiObj)
	{
		$apiObjMethod = $this->appRequest->getApiObjMethod();
		$defMethod    = self::$defaultApiSrc['method'];
		if(is_null(trim($apiObjMethod))){
			return $defMethod;
		}else{
			if(method_exists($apiObj, $apiObjMethod)){
				return $apiObjMethod;		
			}else{
				//Use the main controller
				return $defMethod;
			}//endif
		}//endif
	}//end method 

	private function executeMethodCall(
		$classObj,
		$methodName,
		$methodParams = array()
	)
	{
		return call_user_func_array(array($classObj,$methodName),$methodParams);
	}//end method executeMethodCall

}//end class AppApiCore
