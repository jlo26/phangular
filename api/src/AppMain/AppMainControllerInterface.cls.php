<?php
namespace Api\Src\AppMain;
use	Api\Classes\Core as AppCore;

interface AppMainControllerInterface
{
	public function indexCtrl();
	// public function beforeResponseSend(AppCore\AppApiRequest $appReqObj, AppCore\AppApiResponse $appResponseObj);
	public function beforeResponseSend(AppCore\AppApiRequest $appReqObj,$appResponseObj);
}//end class AppMainControllerInterface