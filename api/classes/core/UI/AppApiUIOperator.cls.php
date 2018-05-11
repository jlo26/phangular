<?php
namespace Api\Classes\Core\UI;
use Api\Classes\Core as AppCore;
use Api\Classes\Core\UI\Translator as AppCoreUITranslator;

class AppApiUIOperator
{
	private $appUiObj;
	private $appUiCtrlObj;
	private $appUiCheckerObj;
	private $appUiCheckerResponseObj;
	private $appReqObj;
	private $uiTransObj;

	public function __construct(
		AppCore\AppApiRequest $appReqObj,
		AppApiUI $appUiObj,
		AppApiUIController $appUiCtrlObj
	)
	{
		$this->appReqObj 	= $appReqObj;
		$this->appUiObj 	= $appUiObj;
		$this->appUiCtrlObj = $appUiCtrlObj;
		// $this->uiTransObj 	= new AppCoreUITranslator\AppApiUITranslator($this->appUiObj);
		$this->uiTransObj 	= new AppCoreUITranslator\AppApiUITranslatorMaterialDesign($this->appUiObj);

		return $this->routeRequest();
	}//end method __construct

	public function routeRequest()
	{
		$displayUi = $this->appReqObj->getApiShowUI(); 
		if($displayUi){
			return $this->displayUI();
		}else{
			return $this->executeUIInputChecker();
		}//end method
	}//end routeRequest

	public function displayUI()
	{
		print $this->uiTransObj->substituteTemplate()->translatedUi;
	}//end method displayGenerator

	public function executeUIInputChecker()
	{
		$this->appUiCheckerObj 	= new AppApiUIChecker(
			$this->appUiObj->getChecker(),
			$this->appUiObj->getVars(),
			$this->appReqObj->getParameter(),
			$this->appUiCtrlObj			
		);
		
		return $this->inputPrefix()
			->validationPrefix()
			->validationSuffix()
			->inputSuffix();
	}//end method displayGenerator

	private function inputPrefix()
	{
		$this->appUiCtrlObj->inputPrefix($this->appReqObj);
		return $this;
	}//end method preInput

	private function validationPrefix()
	{
		$this->appUiCtrlObj->validationPrefix($this->appUiCheckerObj);

		return $this;
	}//end method preInput

	private function validationSuffix()
	{
		$this->appUiCheckerResponseObj = $this->appUiCheckerObj->executeInputChecking();
		$this->appUiCtrlObj->validationSuffix($this->appUiCheckerResponseObj);		
		return $this;
	}//end method preInput

	private function inputSuffix()
	{
		$this->appUiCtrlObj->inputSuffix($this->appReqObj);
		$response = [
			'appResponseType' => 'RESULT_INPUT_CHECKER',
			'items'	=> $this->appUiCheckerResponseObj->toClientResponse()
		];
		header('Content-Type: application/json');
		print json_encode($response,JSON_FORCE_OBJECT);
		return $this;
	}//end method preInput

}//end class AppApiUIOperator