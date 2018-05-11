<?php
namespace Api\Classes\Core\UI;
use Api\Classes\Core as AppCore;

class AppApiUIController
implements AppApiUIControllerInterface
{
	public function inputPrefix(AppCore\AppApiRequest $apiReqOj){}
	public function validationPrefix(AppApiUIChecker $apiUICheckerObj){}
	public function validationSuffix(AppApiUICheckerResponse $apiUICheckerResponseObj){}
	public function inputSuffix(AppCore\AppApiRequest $apiReqOj){}
}//end class AppApiUIController