<?php
error_reporting(E_ALL);
use Api\Classes\Core as AppCore;
use Api\Src\AppMain as AppSrc;

spl_autoload_register("autoload_core",TRUE);
spl_autoload_register("autoload_src",TRUE);
spl_autoload_register("autoload_modules",TRUE);
spl_autoload_register("autoload_ui_support",TRUE);


$apiCoreObj = new AppCore\AppApiCore();
$apiCoreObj->route();

//authenticate
//authorize
//route
//validate
//execute

function autoload_core($className){
	$dirActualPath = '';
	$dirComp       = explode(DS, $className);
	$file          = array_pop($dirComp);

	for($x = 0; $x< count($dirComp); $x++){
		$dirActualPath .= strtolower($dirComp[$x]).DS;
	}//end foreach

	$dirActualPath .= $file.API_EXT;
	if(file_exists($dirActualPath)){
		require_once($dirActualPath);
	}//endif
}//end function

function autoload_src($className){
	// print "tawag lang <br>";
	$fileName   = $className.API_EXT;
	$folderName = substr($className, 0,-10);
	$dirActualPath = APP_SRC.$folderName.DS.$fileName;


	if(file_exists($dirActualPath)){
		require_once($dirActualPath);
	}//endif
}//end function

function autoload_modules($className){
	// print "tawag lang <br>";
	$fileName      = $className.API_EXT;
	$folderName    = substr($className, 0,-10);
	$dirActualPath = APP_MODULES.$folderName.DS.$fileName;


	if(file_exists($dirActualPath)){
		require_once($dirActualPath);
	}//endif
}//end function

function autoload_ui_support($className){
	// print "tawag lang <br>";
	$fileName      = $className.API_EXT;
	$folderName    = substr($className, 0,-6);
	$dirActualPath = APP_MODULES.$folderName.DS.$fileName;


	if(file_exists($dirActualPath)){
		require_once($dirActualPath);
	}//endif
}//end function

