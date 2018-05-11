<?php
namespace Api\Src\AppMain;
use Api\Classes\Core as AppCore;
use Api\Classes\Core\UI as AppUI;
use Api\Classes\Utilities\Filters as AppFilters;

class AppMainController
implements AppMainControllerInterface
{
	protected $apiRequestObj;
	protected $modelObj;
	protected $viewObj;
	public function __construct(
		AppCore\AppApiRequest $apiReqOj,
		$moduleSupport
	)
	{
		$this->apiRequestObj= $apiReqOj;
		$this->modelObj 	= $moduleSupport['MODEL'];
		$this->viewObj 		= $moduleSupport['VIEW'];
		return $this;

	}//end method __construct

	public function indexCtrl()
	{
		AppCore\AppApiScreen::AppMain();
	}//end method indexCtrl

	// public function beforeResponseSend(AppCore\AppApiRequest $appReqObj, AppCore\AppApiResponse $appResponseObj){
	public function beforeResponseSend(AppCore\AppApiRequest $appReqObj, $appResponseObj){

	}//end method beforeResponseSend

	public function userSupportInquiry()
	{
		$data = $this->apiRequestObj->getParameter();
		$data = $data['data'];
		$ret  = [];
		$validationObj = [
			'fname'		=> AppFilters\AppFilterParameter::NAME_GENERIC,
			'lname'		=> AppFilters\AppFilterParameter::NAME_GENERIC,
			'email'		=> AppFilters\AppFilterParameter::EMAIL_ADDRESS,
			'phone'		=> AppFilters\AppFilterParameter::NUMBER_PHONE,
			'subject'	=> AppFilters\AppFilterParameter::EMAIL_SUBJECT,
			'message'	=> AppFilters\AppFilterParameter::EMAIL_MESSAGE,
		];

		$filterObj = new AppCore\AppApiValidationFilter($validationObj);
		$valObj    = new AppCore\AppApiValidation($filterObj);
		$invalidInputCount = $valObj->validateParam($data , FALSE);

		if(count($invalidInputCount) == 0){

			$data = AppCore\AppApiValidation::$validInputs;
			$src  = array(':FNAME',':LNAME',':MSG');
			$rep  = array($data['fname'],$data['lname'],$data['message']);
			$msg  = str_replace($src,$rep,EMAIL_MESSAGE);
			$subj = $data['subject'];

			$stat = $this->sendEmailToSupport($msg,$subj);
			$ret  = [ 'stat' => $stat ];
		}else{
			$ret  = [ 'stat' => FALSE ,'error'=> $invalidInputCount ];
		}//endif
		
		header('Content-Type: application/json');
		print json_encode($ret, JSON_FORCE_OBJECT);
	}//end method userSupportInquiry

	protected function sendEmailToSupport($msg,$subj)
	{
	    /*$to      = 'tagapagpatupadsaweb@gmail.com';
		$subject = 'the subject';
		$message = 'hello';*/
		$to      = EMAIL_SENDER;
		$subject = $subj;
		$message = $msg;
		$headers = EMAIL_HEADER;

		// print "$to<br>";
		// print "$subject<br>";
		// print "$message<br>";
		// print "$headers<br>";
		return mail($to, $subject, $message, $headers);
	}//end method sendEmailToSupport

	public function appUIOperatorRunner(AppUI\AppApiUIOperator $uiOperatorObj)
	{
		$reqObj   = $this->apiRequestObj;
		$isShowUI = $reqObj->getShowUI();

		if($isShowUI){
			$uiOperatorObj->preDisplay($reqObj);
			$uiOperatorObj->translateUITemplate();
			$uiOperatorObj->postDisplay($reqObj);
		}else{
			$uiOperatorObj->preInput($reqObj);
			$uiOperatorObj->postInput($reqObj);
		}//endif
	}//end method appUIOperatorRunner


	public function appClientScriptLoader()
	{
		$data = $this->apiRequestObj->getParameter();
		$data = $data['data'];

		if(isset($data['type']) && isset($data['index'])){
			$clientFiles = [
				'css'  => [
					'ui-default'   => [
						APP_ANGJS_PATH_BASE.'angular-csp.css',
					],
					'ui-md'	=> [
						APP_ANGJS_PATH_BASE.'angular-csp.css',
						APP_ANGJS_MD_BASE.'angular-material.min.css',
					],
				],


				'js'   => [
					'ui-default'    => [
						APP_ANGJS_PATH_BASE.'angular.min.js',
						APP_ANGJS_PATH_BASE.'angular-route.min.js',
						APP_ANGJS_PATH_BASE.'angular-messages.min.js',
						APP_ANGJS_PATH_BASE.'angular-sanitize.min.js',
						APP_API_ANGJS.'app.api.module.js',
						APP_API_ANGJS.'app.api.controller.js',
						APP_API_ANGJS.'app.api.service.js',
					],
					'ui-md'    => [
						APP_ANGJS_PATH_BASE.'angular.min.js',
						APP_ANGJS_PATH_BASE.'angular-animate.min.js',
						APP_ANGJS_PATH_BASE.'angular-aria.min.js',
						APP_ANGJS_PATH_BASE.'angular-route.min.js',
						APP_ANGJS_PATH_BASE.'angular-messages.min.js',
						APP_ANGJS_PATH_BASE.'angular-sanitize.min.js',
						APP_ANGJS_MD_BASE.'angular-material.min.js',
						APP_API_ANGJS_MOD,
						APP_API_ANGJS_CTRL,
						APP_API_ANGJS_SERV,
					],
				],
			];

			$fileIndex = trim($data['index']);			
			switch($data['type']){
				case 'css':

					if( array_key_exists($fileIndex,$clientFiles['css']) ){
						$files = $clientFiles['css'][$fileIndex];
						
						AppCore\AppApiClientScriptLoader::addCSSArrayFile($files);
						print AppCore\AppApiClientScriptLoader::loadCSSFiles();

					}//endif
					break;
				case 'js':

					if( array_key_exists($fileIndex,$clientFiles['js']) ){
						$files = $clientFiles['js'][$fileIndex];
						
						AppCore\AppApiClientScriptLoader::addJSArrayFile($files);
						print AppCore\AppApiClientScriptLoader::loadJSFiles();

					}//endif
					break;
			}//end switch
		}//end method
	}//end method appClientScriptLoader

}//end class AppMainController