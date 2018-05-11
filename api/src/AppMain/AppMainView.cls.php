<?php
namespace Api\Src\AppMain;
use Api\Classes\Core as AppCore;
use Api\Classes\Core\UI as AppCoreUI;
use Api\Modules as AppModules;

class AppMainView
{
	protected $appApiModel;
	protected $apiRequestObj;
	public function __construct($appModelObj)
	{
		$this->appApiModel 	= $appModelObj;
		// $this->apiRequestObj= $appModelObj->apiRequestObj;
		return $this;
	}//end method __construct

	public function initUiOperator(AppCoreUI\AppApiUI $tempObj)
	{
		$uiObj 		   = $tempObj;		
		$callerClassNS = dirname(get_called_class());
		$uiCtrlObj 	   = $uiObj->initController($callerClassNS);
		
		return new AppCoreUI\AppApiUIOperator(
			$this->apiRequestObj,
			$uiObj,
			$uiCtrlObj
		);		 
	}//end method 

}//end class AppMainView