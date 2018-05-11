<?php
namespace Api\Modules\App001;
use Api\Src\AppMain as AppMainApi;
use Api\Classes\Core as AppCore;

class App001Controller
extends AppMainApi\AppMainController
{

	public $modelObj;
	public $viewObj;
	public function __construct(
		AppCore\AppApiRequest $apiReqObj,
		$moduleSupport
	)
	{
		$this->apiRequestObj = $apiReqObj;
		$this->modelObj = $moduleSupport["MODEL"];
		$this->viewObj 	= $moduleSupport["VIEW"];

		return $this;
	}//end method __construct

	public function indexCtrl()
	{
		AppCore\AppApiScreen::App001Main(
			[
				'This is page title',
				'Hello World out there',
				'This is below'
			]
		);
	}//end method indexCtrl

	// public function beforeResponseSend(AppCore\AppApiRequest $appReqObj, AppCore\AppApiResponse $appResponseObj){
	public function beforeResponseSend(AppCore\AppApiRequest $appReqObj,$appResponseObj){
		// print "before send <br>";
		// print_r($appResponseObj);
		// print "/before send <br>";
	}//end method beforeResponseSend
	
	public function userFormCtrl()
	{
		// return $this->viewObj->userFormView();

		// print $this->modelObj->insertEmployeeList();
		print_r($this->modelObj->getStatusList());
		return $this->viewObj->employeeFormView();
	}//end method userFormCtrl
}//end class App001Controller