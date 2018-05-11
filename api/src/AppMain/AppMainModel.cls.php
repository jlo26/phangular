<?php
namespace Api\Src\AppMain;
use Api\Classes\Core as AppCore;
use Api\Classes\Core\Database as AppCoreDb;

class AppMainModel
{
	protected $apiRequestObj;
	protected $apiDbConnObj;
	protected $apiDbConnName;
	public function __construct(AppCore\AppApiRequest $appReqObj)
	{
		$this->apiRequestObj = $appReqObj;
		$cred = [
			'DB_DRIVER'	=> 'MYSQL',
			'DB_NAME'	=> '',
			'DSN'		=> 'mysql:dbname=wright.agency.db;host=localhost',
			'USERNAME'	=> 'root',
			'PASSWORD'	=> '',
			'OPTIONS'	=> [
				\PDO::ATTR_PERSISTENT => TRUE
			],
		];
		
		$credObj 			 = new AppCoreDb\AppApiDatabaseCredentials($cred);
		$this->apiDbConnObj  = AppCoreDb\AppApiDatabaseOperator::connect($credObj);
		$this->apiDbConnName = 'AppCoreDb\\AppApiDatabaseOperator';

		return $this;
	}//end method __construct
}//end class AppMainModel