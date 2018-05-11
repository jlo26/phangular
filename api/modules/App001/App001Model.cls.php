<?php
namespace Api\Modules\App001;
use Api\Src\AppMain as AppMainApi;
use Api\Classes\Core as AppCore;
use Api\Classes\Core\Database as AppCoreDb;

class App001Model
extends AppMainApi\AppMainModel
{
	public function __construct(AppCore\AppApiRequest $apiReqObj)
	{
		$this->appApiReq = $apiReqObj;
		parent::__construct($apiReqObj);
		return $this;
	}//end method __construct

	public function insertEmployeeList()
	{
		AppCoreDb\AppApiDatabaseOperator::setTable('s003_status');
		AppCoreDb\AppApiDatabaseOperator::setColumns([
			'sts_status_id',
			'sts_name',
			'sts_desc',
			'sts_created_by',
			'sts_updated_by',
		]);

		AppCoreDb\AppApiDatabaseOperator::setValues(
			[
				NULL,
				'active',
				'Active status - in use',
				'0769',
				'0769',
			]
		);
		return AppCoreDb\AppApiDatabaseOperator::create();
	}//end method

	public function getStatusList()
	{
		AppCoreDb\AppApiDatabaseOperator::setTable('s003_status');
		AppCoreDb\AppApiDatabaseOperator::setColumns([
			'sts_status_id',
			'sts_name',
			'sts_desc',
			'sts_created_by',
			'sts_updated_by',
		]);
		AppCoreDb\AppApiDatabaseOperator::setColumns([
			'*'
		]);

		// AppCoreDb\AppApiDatabaseOperator::setCondition([
		// 	'placeholder'	=> ' sts_status_id = :1',
		// 	'binding'		=> [':1' => 1]
		// ]);
		

		AppCoreDb\AppApiDatabaseOperator::setResultRange(1,1);
		AppCoreDb\AppApiDatabaseOperator::setResultHasLimit(FALSE);

		return AppCoreDb\AppApiDatabaseOperator::read();
	}//end method

	public function statusList()
	{
		AppCoreDb\AppApiDatabaseRecord::s003_status();
	}//end method

}//end class App001Model