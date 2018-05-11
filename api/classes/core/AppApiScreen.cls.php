<?php
namespace Api\Classes\Core;

class AppApiScreen
{
	
	public static $baseScreenDir  = APP_RESOURCE_SCREEN;
	public static $screenNotFound = "[ SCREEN NOT FOUND ]";

	public static function __callStatic($methodName, $args)
	{
		/**
		 * Calls the view filename of the view.
		 * from APP_RESOURCE_SCREEN directory
		*/
		$nameExploded 	= explode('_',$methodName);
		$getContentOnly = FALSE;
		//sample AppApiScreen::GC_App000Screen();
		if(isset($nameExploded[0]) && trim($nameExploded[0]) == 'GC'){
			$getContentOnly = TRUE;
		}//endif

		$fileName = ($getContentOnly)? $nameExploded[1] : $methodName;
		$fileName = self::$baseScreenDir.$fileName.API_EXT_UI;
		if(file_exists($fileName)){
			//Pass along the data for screen usage
			if($getContentOnly){
				return file_get_contents($fileName);		
			}else{
				$uc = $args;			
				require_once($fileName);
			}//endif

		}else{
			return self::$screenNotFound;
		}//end

	}//end method __callStatic

}//end class AppApiScreen
