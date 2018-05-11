<?php
namespace Api\Modules\Wright001;
use Api\Src\AppMain as AppMainApi;
use Api\Classes\Core as AppCore;

class Wright001Model
extends AppMainApi\AppMainModel
{
	public function __construct(AppCore\AppApiRequest $apiReqObj)
	{
		$this->appApiReq = $apiReqObj;
		return $this;
	}//end method __construct	

}//end class App001Model