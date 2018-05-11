<?php

class AppApiDatabaseRecord
{
    public static function __callStatic($methodName, $args)
	{
		/**
		 * Calls the view filename of the view.
		 * from APP_RESOURCE_SCREEN directory
		*/
		$tableName 	= $methodName;
		$getContentOnly = FALSE;
		$tabDef = AppApiDatabaseOperator::getTableDefinition($tableName);
		print "<pre>";
		print_r(" hheheh ???????? ");
		print_r($tabDef);
		print "</pre>";
		
		// if(isset($nameExploded[0]) && trim($nameExploded[0]) == 'GC'){
		// 	$getContentOnly = TRUE;
		// }//endif

		// $fileName = ($getContentOnly)? $nameExploded[1] : $methodName;
		// $fileName = self::$baseScreenDir.$fileName.API_EXT_UI;
		// if(file_exists($fileName)){
		// 	//Pass along the data for screen usage
		// 	if($getContentOnly){
		// 		return file_get_contents($fileName);		
		// 	}else{
		// 		$uc = $args;			
		// 		require_once($fileName);
		// 	}//endif

		// }else{
		// 	return self::$screenNotFound;
		// }//end

	}//end method __callStatic

}//end class AppApiDatabaseRecord