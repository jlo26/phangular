<?php
namespace Api\Classes\Core\UI;
use Api\Classes\Core as AppCore;

interface AppApiUIControllerInterface
{
	public function inputPrefix(AppCore\AppApiRequest $apiReqObj);
	public function validationPrefix(AppApiUIChecker $apiUICheckerObj);
	public function validationSuffix(AppApiUICheckerResponse $apiUICheckerResponseObj);
	public function inputSuffix(AppCore\AppApiRequest $apiReqOj);
}//end class AppApiUIControllerInterface