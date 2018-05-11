<?php
namespace Api\Classes\Core\Database;

class AppApiDatabaseCredentials
{

	private $dsn;
	private $username;
	private $password;
	private $options;
	private $dbName;
	private $dbDriver;
	private $fileName;
	private $arrayConfig;

	public function __construct( array $arrayConfig ,string $filenName = '')
	{	
		$this->fileName 	= $filenName;
		$this->arrayConfig 	= $arrayConfig;

		if(!$this->loadArrayCredentials()){
			$this->loadFileCredentials();
		}//endif

		return $this;

	}//end method __construct


	public function __call($fxName,$val)
	{
		$operation = substr($fxName,0,3);
		$fxName    = substr($fxName,3);
		$propName  = lcfirst($fxName);
		if(property_exists($this, $propName)){
			if(strtolower(trim($operation)) == 'set'){
				$this->$propName = $val;

				return $this;
			}else{

				return $this->$propName;
			}//endif
		}//end if
	}//end method
	
	public function loadFileCredentials()
	{
		if(file_exists($this->fileName)){
			$this->arrayConfig 	= $configArray;

			$result = $this->validateFileCredentials();
			if($result){
				$this->getDbCredentials();

				return TRUE;
			}//endif
		}//endif
		return FALSE;
	}//end method loadFileCredentials

	public function loadArrayCredentials()
	{
		$result = $this->validateCredentials();
		if($result){
			$this->getDbCredentials();

			return TRUE;
		}//endif
		return FALSE;
	}//end method loadFileCredentials

	private function validateFileCredentials()
	{
		//Check if the database credentials is in 2d array and
		//has the following required keys, 
		//'DB_NAME','DB_DRIVER' ,'DNS','USERNAME','PASSWORD' and 'OPTIONS'
		require_once($this->fileName);	
		return $this->validateCredentials();

	}//end method validateFileCredentials

	private function validateCredentials()
	{
		$config = $this->arrayConfig;

		return (
			isset($config['DB_NAME']) &&
			isset($config['DB_DRIVER']) &&
			isset($config['DSN']) &&
			isset($config['USERNAME']) &&
			isset($config['PASSWORD']) &&
			isset($config['OPTIONS'])
		);	
	}//end method validateCredentials

	private function getDbCredentials()
	{
		$this->dsn 		= $this->arrayConfig['DSN'];
		$this->username = $this->arrayConfig['USERNAME'];
		$this->password = $this->arrayConfig['PASSWORD'];
		$this->options 	= $this->arrayConfig['OPTIONS'];
		$this->dbName	= $this->arrayConfig['DB_NAME'];
		$this->dbDriver	= $this->arrayConfig['DB_DRIVER'];
	}//end method getDbCredentials

}//end class AppApiDatabaseCredentials
