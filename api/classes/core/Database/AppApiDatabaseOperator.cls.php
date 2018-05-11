<?php
namespace Api\Classes\Core\Database;
use Api\Src\AppMain as AppMain;
use Api\Classes\Core\Http as AppCoreHttp;

class AppApiDatabaseOperator
{
	CONST SQL_DEFAULT = [
		'MYSQL' =>	[
			'CREATE' 	=> "INSERT INTO ::table:: (::columns::) values( ::values:: )",
			'READ' 		=> "SELECT ::columns:: FROM ::table:: ::condition:: ",
			'UPDATE' 	=> "UPDATE ::table:: ::columns:: ::condition::",
			'DELETE' 	=> "DELETE FROM ::table:: ::condition:: ",
		],
	];
	private static $sql;
	private static $dbConnection;
	private static $dbCredentials;
	private static $querySet;
	
	private static $table;
	private static $columns;
	private static $values;
	private static $condition;
	private static $resultHasLimit;
	private static $resultOffset;
	private static $resultCount;
	private static $placeHolder = [
		'tab'	=> '::table::',
		'col'	=> '::columns::',
		'val'	=> '::values::',
		'con'	=> '::condition::',
	];


	public static function __callStatic($fxName,$val)
	{
		$operation = substr($fxName,0,3);
		$fxName    = substr($fxName,3);
		$propName  = lcfirst($fxName);
		if(property_exists(get_class() , $propName)){
			if(strtolower(trim($operation)) == 'set'){

				self::$$propName = $val[0];
			}else{

				return self::$$propName;
			}//endif
		}//end if
	}//end method

	public static function connect(AppApiDatabaseCredentials $dbCredentialsObj)
	{	
		try{
			self::$dbConnection = new \PDO(
				$dbCredentialsObj->getDsn(), 
				$dbCredentialsObj->getUsername(), 
				$dbCredentialsObj->getPassword(),
				$dbCredentialsObj->getOptions()
			); 
			
			$driverName 	= strtoupper($dbCredentialsObj->getDbDriver());
			self::$querySet = self::SQL_DEFAULT[$driverName];
			self::$resultHasLimit = FALSE;
			return self::$dbConnection;

		}catch(\PDOException $e){

			print $e->getMessage();
			exit();
		}//end try/catch
			

		return FALSE;
	}//end method connect
	
	public static function create()
	{
		$op = 'create';
		$canProceed = self::validateSqlElement($op);
		$dataBinding = [];

		if($canProceed){		
			$preparedEntry = self::prepareCreate();
			$dataBinding   = $preparedEntry['binding'];
			$colRep        = implode(',' ,self::$columns);
			$valueRep      = implode(',' ,$preparedEntry['forPlaceholder']);
			$replacement   = [
				self::$table,
				$colRep,
				$valueRep
			];

			$sql 	 = self::substituteSqlElement($op ,$replacement);
			$stmtObj = self::$dbConnection->prepare($sql);
			$stmtObj->execute($dataBinding);

			return self::$dbConnection->lastInsertId();
		}//endif

		return FALSE;

	}//end method

	public static function  read()
	{
		$op = 'read';
		$canProceed 	= self::validateSqlElement($op);
		$preparedEntry	= [];

		if($canProceed){
			$preparedEntry = self::prepareRead();

			$dataBinding   = $preparedEntry['conditionBinding'];
			$colRep        = $preparedEntry['columns'];
			$condRep       = $preparedEntry['conditionPh'];
			$replacement   = [
				self::$table,
				$colRep,
				$condRep
			];

			$sql 	 = self::substituteSqlElement($op ,$replacement);
			$sql 	.= self::getResultRange();

			$stmtObj = self::$dbConnection->prepare($sql);
			$stmtObj->execute($dataBinding);

			return $stmtObj->fetchAll();

		}//endif

		return FALSE;
	}//end method read

	public static function setResultRange(int $offset ,int $recCount)
	{
		self::$resultOffset = $offset;
		self::$resultCount 	= $recCount;
	}//end method 

	private static function prepareCreate()
	{
		$prepared = [];
		$colIndex = '';

		foreach(self::$columns as $key => $currentColumn){
			$colIndex = ':'.$currentColumn;
			$prepared['binding'][$colIndex] = self::$values[$key];
			$prepared['forPlaceholder'][] 	= $colIndex;
		}//end foreach

		return $prepared;
	}//end method prepareCreate

	private static function prepareRead()
	{
		$prepared = [];
		$columns  = ''; 

		$conditionPh 		= '';
		$conditionBinding 	= [];
		//Check if there are conditions set
		if(
			is_array(self::$condition)  && 
			count(self::$condition) > 0 &&
			isset(self::$condition['placeholder']) && 
			isset(self::$condition['binding'])     &&
			is_array(self::$condition['binding'])  &&
			count(self::$condition['binding']) > 0
		){
			$conditionPh 	  = 'WHERE '.self::$condition['placeholder'];
			$conditionBinding = self::$condition['binding'];
			self::$condition  = $conditionPh;
		}//endif

		if(count(self::$columns) == 1){
			$columns = self::$columns[0];
		}else{
			$columns = implode(',',self::$columns);
		}//endif
			
		$prepared['columns'] 			= $columns;
		$prepared['conditionPh'] 		= $conditionPh;
		$prepared['conditionBinding']   = $conditionBinding;

		return $prepared;
	}//end method prepareRead

	private static function validateSqlElement($op)
	{
		switch($op){
			case 'create':

				return (
					trim(self::$table) !== NULL && 
					is_array(self::$columns) && count(self::$columns) > 0 &&
					is_array(self::$values)  && count(self::$values) > 0
				);
				
			case 'read':

				return ( 
					trim(self::$table) !== NULL && 
					is_array(self::$columns) 	&& count(self::$columns) > 0
				);

			case 'update':

				return (
					trim(self::$table) !== NULL && 
					is_array(self::$columns) && count(self::$columns) > 0 &&
					is_array(self::$values)  && count(self::$values)  > 0
				);

			case 'delete':
				return (
					trim(self::$table) !== NULL && 
					is_array(self::$condition) && count(self::$condition) > 0
				);
		}//end switch

	}//end method validateSqlElement

	private static function substituteSqlElement($op, $replacement)
	{
		switch($op){
			case 'create':
				$sub    = $replacement;
				$sql    = self::$querySet['CREATE'];
				$search = [
					self::$placeHolder['tab'],
					self::$placeHolder['col'],
					self::$placeHolder['val']
				];

				return str_replace($search, $sub, $sql);

			case 'read':

				$sub    = $replacement;
				$sql    = self::$querySet['READ'];
				$search = [
					self::$placeHolder['tab'],
					self::$placeHolder['col'],
					self::$placeHolder['con']
				];

				return str_replace($search, $sub, $sql);

			case 'update':

			case 'delete':
		}//end switch

	}//end method substituteSqlElements

	private static function getResultRange()
	{
		if(self::$resultHasLimit){
			return 'LIMIT '.self::$resultOffset.','.self::$resultCount;
		}//endif

		return '';
	}//end method getResultRange

	private static function getTableDefinition($tableName)
	{
		$sql     = "DESC $tableName";
		$stmtObj = self::$dbConnection->prepare($sql);
		$stmtObj->execute();
		return $stmtObj->fetchAll();
	}//end method 
	
}//end class AppApiDatabaseOperator
