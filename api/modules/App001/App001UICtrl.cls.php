<?php
namespace Api\Modules\App001;
use Api\Classes\Core\UI as AppCoreUI;
use Api\Classes\Core as AppCore;

class App001UICtrl
extends AppCoreUI\AppApiUIController
{
	public function inputPrefix(AppCore\AppApiRequest $apiReqOj)
	{
		// print "inputPrefix return<br>";
		// print_r($apiReqOj->getParameter());
		// print_r("After ng return<br>");
	}

	public function validationPrefix(AppCoreUI\AppApiUIChecker $apiUICheckerObj)
	{
		// print "validationPrefix return<br>";
		// print_r($apiUICheckerObj);
		// print_r("After ng return<br>"); 
	}
	public function validationSuffix(AppCoreUI\AppApiUICheckerResponse $apiUICheckerResponseObj)
	{
		// print "validationSuffix return<br>";
		//print_r($apiUICheckerResponseObj);
		// print_r("After ng return<br>");

	}//end method validationPrefix
	
	public function inputSuffix(AppCore\AppApiRequest $apiReqOj)
	{
		// print "inputSuffix return <br>";
	}//end method inputSuffix

	public function valueCheckingLastName($name, $value)
	{
		return [
			'valid' =>	FALSE,
			'error'	=> 	" Value $value is invalid!"
		];
	}//end method 
}//end class