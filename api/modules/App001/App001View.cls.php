<?php
namespace Api\Modules\App001;
use Api\Src\AppMain as AppMainApi;
use Api\Classes\Core as AppCore;
use Api\Classes\Core\UI as AppCoreUI;

class App001View
extends AppMainApi\AppMainView
{

	protected $appApiModel;
	protected $apiRequestObj;
	// protected $apiResponseObj;

	public function __construct($appModelObj)
	{
		$this->appApiModel 	 	= $appModelObj;
		$this->apiRequestObj 	= $appModelObj->appApiReq;
		// $this->apiResponseObj 	= $appResponseObj;
	}//end method __construct

	public function userFormView()
	{
		/**
		 * If there is manualChecker, autoChecker is disregarded
		 * mode = 1 or 2 ,default 1
		 * 	1: if manualChecker exist, it will be used,
		 * 	2: both will be used,
 		 */
		$checkerDefinition = [
			'errorChecking'	=> 1,
			'errorDisplay'	=> 1,
			'items'	=>	[
				'lname' => [
					'mode'			=>	AppCoreUI\AppApiUIChecker::CHECKING_MODE['AUTO_ONLY'],
					'manualChecker'	=>	'valueCheckingLastName',
					'autoChecker'	=>	[
						'validation'	=> [
							'type'	=>	AppCoreUI\AppApiUICheckerItemTypes::CT_STRING,
							'min'	=>	2,
							'max'	=>	50,
							'regex'	=>	''
						],
						'errorMessage'	=> [
							'type'	=>	'Input [ Type] is invalid',
							'min'	=>	'Input [ Minimum ] is invalid',
							'max'	=>	'Input [ Maximum ] is invalid',
							'regex'	=>	'Input [ RegEx ] is invalid',
						],
					],
				],
				'fname' => [
					'mode'			=>	AppCoreUI\AppApiUIChecker::CHECKING_MODE['AUTO_ONLY'],
					'manualChecker'	=>	'methodName',
					'autoChecker'	=>	[
						'validation'	=> [
							'type'	=>	AppCoreUI\AppApiUICheckerItemTypes::CT_STRING,
							'min'	=>	20,
							'max'	=>	220,
							'regex'	=>	''
						],
						'errorMessage'	=> [
							'type'	=>	'Input 2[ Type] is invalid',
							'min'	=>	'Input 2[ Minimum ] is invalid',
							'max'	=>	'Input 2[ Maximum ] is invalid',
							'regex'	=>	'Input 2[ RegEx ] is invalid',
						],
					],
				],
			],
		];

		$templateArray = [
			"ctrl"		=> "App001UICtrl",
			"temp"		=> AppCore\AppApiScreen::GC_App001UserForm(),
			"vars"		=> ['lname','fname'],
			"event"		=> "click",
			"checker"	=> $checkerDefinition
		];
		
		return $this->initUiOperator(
			AppCoreUI\AppApiUITemplate::standAlone($templateArray)
		);
	}//end method userFormView

	public function employeeFormView()
	{
		/**
		 * If there is manualChecker, autoChecker is disregarded
		 * mode = 1 or 2 ,default 1
		 * 	1: if manualChecker exist, it will be used,
		 * 	2: both will be used,
 		 */
		$checkerDefinition = [
			'errorChecking'	=> 1,
			'errorDisplay'	=> 1,
			'items'	=>	[
				'lname' => [
					'mode'			=>	AppCoreUI\AppApiUIChecker::CHECKING_MODE['AUTO_ONLY'],
					'manualChecker'	=>	'valueCheckingLastName',
					'autoChecker'	=>	[
						'validation'	=> [
							'type'	=>	AppCoreUI\AppApiUICheckerItemTypes::CT_STRING,
							'min'	=>	2,
							'max'	=>	50,
							'regex'	=>	''
						],
						'errorMessage'	=> [
							'type'	=>	'Input [ Type] is invalid',
							'min'	=>	'Input [ Minimum ] is invalid',
							'max'	=>	'Input [ Maximum ] is invalid',
							'regex'	=>	'Input [ RegEx ] is invalid',
						],
					],
				],
				'fname' => [
					'mode'			=>	AppCoreUI\AppApiUIChecker::CHECKING_MODE['AUTO_ONLY'],
					'manualChecker'	=>	'methodName',
					'autoChecker'	=>	[
						'validation'	=> [
							'type'	=>	AppCoreUI\AppApiUICheckerItemTypes::CT_STRING,
							'min'	=>	20,
							'max'	=>	220,
							'regex'	=>	''
						],
						'errorMessage'	=> [
							'type'	=>	'Input 2[ Type] is invalid',
							'min'	=>	'Input 2[ Minimum ] is invalid',
							'max'	=>	'Input 2[ Maximum ] is invalid',
							'regex'	=>	'Input 2[ RegEx ] is invalid',
						],
					],
				],
			],
		];

		$templateArray = [
			"ctrl"		=> "App001UICtrl",
			"temp"		=> AppCore\AppApiScreen::GC_App001EmployeeOfTheMonth(),
			"vars"		=> ['fname','lname'],
			"event"		=> "click",
			"checker"	=> $checkerDefinition
		];
		
		return $this->initUiOperator(
			AppCoreUI\AppApiUITemplate::standAlone($templateArray)
		);
	}//end method employeeFormView

}//end class App001View