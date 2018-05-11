<?php
namespace Api\Classes\Core\UI\Translator;
use Api\Classes\Core\UI as AppCoreUI;

class AppApiUITranslatorMaterialDesign
{
	// CONST ANGULAR_BASE_PATH	= APP_RESOURCE_ANGJS;
	// CONST ANGULAR_APP_PATH	= APP_API_ANGJS;
	// CONST ANGULAR_LIB 	= 'angular-library'.DS;
	// CONST ANGULAR_EXT 	= 'angular-material'.DS;

	public $translatedUi;
	private $appUiObj;
	private $templateHead;
	private $templateFoot;
	// private $angularCSS = [
	// 	self::ANGULAR_LIB.'angular-csp.css',
	// ];
	// private $angularJS  = [
	// 	self::ANGULAR_LIB.'angular.min.js',
	// 	self::ANGULAR_LIB.'angular-sanitize.min.js',
	// 	self::ANGULAR_LIB.'angular-messages.min.js',
	// 	self::ANGULAR_LIB.'angular-aria.min.js',
	// 	self::ANGULAR_LIB.'angular-animate.min.js',
	// 	self::ANGULAR_LIB.'angular-route.min.js',
	// ];
	// private $angularExtCSS = [
	// 	self::ANGULAR_EXT.'angular-material.min.css',
	// ];
	// private $angularExtJS = [
	// 	self::ANGULAR_EXT.'angular-material.min.js',
	// ];
	// private $angularAppApiJS = [
	// 	self::ANGULAR_APP_PATH.'app.api.module.js',
	// 	self::ANGULAR_APP_PATH.'app.api.controller.js',
	// 	self::ANGULAR_APP_PATH.'app.api.service.js',
	// ];
	

	public static $modelDirDefinition =  [
		"directive"			 	=> "ng-model='::var::' ng-disabled='::disab::'",
		"dirConPh"		 		=> "::var::",
		"dirConDisabledPh" 		=> "::disab::",
		"phStringPrefix"	 	=> "@@",
		"mainObjVarContainer" 	=> "__appVars",
		"childObjVarContainer" 	=> "appModel",
		"childObjIsDisabledCon"	=> "isDisabled"
	] ;
		
	public static $clientErrorDefinition = [
		"errorVariablePrefix"	=> [
			'showFlag'	=> '__appVars.errorShow',
			'message'	=> '__appVars.errorMsg',
		],
		"phErrorShowFlag"	 => "__ERRORSHOW__",
		"phErrorMessage"	 => "__ERRORMSG__",
		"phStringPrefix"	 => ":e@@_",
		"jsVarErrorModel"	 => "::errorModel::",
		"directive"			 => "<span ng-show='__ERRORSHOW__.::errorModel::'>[che]__ERRORMSG__.::errorModel::[rold]</span>",
	];

	public function __construct(AppCoreUI\AppApiUI $appUiObj)
	{
		$this->appUiObj 	= $appUiObj;
		$this->templateHead = '	
        <!DOCTYPE html>
        <html>
            <head>
                <title>Hello World</title>
                <link rel="stylesheet" href="client_script_loader.php?type=css&index=ui-md"> 
                <!--link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.8/angular-material.min.css"-->               
                <script type="text/javascript" src="client_script_loader.php?type=js&index=ui-md"></script>
            </head>
            <body ng-app="appApiModule" ng-cloak>';		

		$this->templateFoot = '
            </body>
        </html>';

		return $this;
	}//end method __construct

	public function substituteTemplate()
	{	
		$template   = $this->appUiObj->getTemp();
		$varPhList 	= $this->createVarPlaceholder();
		$modDirList	= $this->createModelDirective();

		$errorPH       = $this->createErrorVarPlaceholder();
		$errorHTMLTemp = $this->createErrorModelDirective();

		//Make models from placeholder
		$this->translatedUi = str_replace($varPhList, $modDirList, $template);
		//Make error html holder from placeholder
		$this->translatedUi = str_replace($errorPH, $errorHTMLTemp, $this->translatedUi);
		$this->translatedUi = str_replace(['[che]','[rold]'], ['{{','}}'], $this->translatedUi);

		$this->translatedUi = "
			<div ng-controller = '__AppApiController'>
				".$this->translatedUi."
			</div>
		";
		if($this->appUiObj->getType() == AppCoreUI\AppApiUITemplate::UI_STANDALONE){
			$this->translatedUi = $this->templateHead.$this->translatedUi.$this->templateFoot;
		}//endif

		return $this;
	}//end method subVarPlaceholder

	private function createVarPlaceholder()
	{
		$vars     = $this->appUiObj->getVars();
		$varPhStr = self::$modelDirDefinition['phStringPrefix'];
		$ph   	  = [];
		foreach($vars as $key => $currentVar){
			$ph[] = $varPhStr.trim($currentVar);
		}//end foreach

		return $ph;
	}//end method createVarPlaceholder

	private function createModelDirective()
	{
		$modDirective = [];
		$vars 		  = $this->appUiObj->getVars();
		$def  		  = self::$modelDirDefinition;
		$jsObjName    = $def['mainObjVarContainer'].'.'.$def['childObjVarContainer'];
		$directive    = $def['directive'];
		$dirConPh 	  = $def['dirConPh'];
		$modelName    = "";

		$jsObjDisbName = $def['mainObjVarContainer'].'.'.$def['childObjIsDisabledCon'];
		$dirConDisbPh  = $def['dirConDisabledPh'];
		$modelNameDisb = "";

		foreach($vars as $key => $currentVar){
			$modelName 		= $jsObjName.".".trim($currentVar);
			$modelNameDisb 	= $jsObjDisbName.".".trim($currentVar);
			$modDirective[] = str_replace(
				[ $dirConPh ,$dirConDisbPh ], 
				[ $modelName ,$modelNameDisb ], 
				$directive
			);
		}//end foreach

		return $modDirective;
	}//end method createVarPlaceholder

	private function createErrorVarPlaceholder()
	{
		$vars     = $this->appUiObj->getVars();
		$varPhStr = self::$clientErrorDefinition['phStringPrefix'];
		$ph   	  = [];
		foreach($vars as $key => $currentVar){
			$ph[] = $varPhStr.trim($currentVar);
		}//end foreach

		return $ph;
	}//end method createVarPlaceholder

	private function createErrorModelDirective()
	{
		$modDirective = [];
		$vars 		  = $this->appUiObj->getVars();
		$def  		  = self::$clientErrorDefinition;
		$modelPlaceholder =	$def['jsVarErrorModel'];
		$template         = $this->getErrorDisplayTemplate();
		
		foreach($vars as $key => $currentVar){
			$modDirective[] = str_replace(
				$modelPlaceholder, 
				$currentVar,
				$template
			);			
		}//end foreach
		// print "</pre>";

		return $modDirective;
	}//end method createVarPlaceholder

	private function getErrorDisplayTemplate()
	{
		$def  		  	= self::$clientErrorDefinition;
		$directive    	= $def['directive'];
		$errorShowTemp	= $def['phErrorShowFlag'];
		$errorMsgTemp 	= $def['phErrorMessage'];
		//Replace the angular js variable
		$template = str_replace(
			$errorShowTemp,
			$def['errorVariablePrefix']['showFlag'],
			$directive
		);
		$template = str_replace(
			$errorMsgTemp,
			$def['errorVariablePrefix']['message'],
			$template
		);
		// print_r(htmlspecialchars($template));
		return $template;
	}//end method

	// private function generateCSSIncludes()
	// {
	// 	$this->templateHead = "";
	// 	$format   = '<link rel="stylesheet" href="%s">';
	// 	$files 	  = $this->angularCSS;
	// 	$extFiles = $this->angularExtCSS;

	// 	foreach($files as $key => $currentFile){
	// 		$file = self::ANGULAR_BASE_PATH.$currentFile;
	// 		$this->templateHead .= sprintf($format,$file);
	// 	}//end foreach

		
	// 	foreach($extFiles as $key => $currentFile){
	// 		$file = self::ANGULAR_BASE_PATH.$currentFile;
	// 		$this->templateHead .= sprintf($format,$file);
	// 	}//end foreach	

	// 	return $this;
	// }//end method
	
	// private function generateJSIncludes()
	// {
	// 	$this->templateFoot = "";
	// 	$format   = '<script type="text/javascript" src="%s"></script>';
	// 	$files 	  = $this->angularJS;
	// 	$extFiles = $this->angularExtJS;
	// 	$apiFiles = $this->angularAppApiJS;
		
	// 	foreach($files as $key => $currentFile){
	// 		$file = self::ANGULAR_BASE_PATH.$currentFile;
	// 		$this->templateFoot .= sprintf($format,$file);
	// 	}//end foreach
		
	// 	foreach($extFiles as $key => $currentFile){
	// 		$file = self::ANGULAR_BASE_PATH.$currentFile;
	// 		$this->templateFoot .= sprintf($format,$file);
	// 	}//end foreach

	// 	foreach($apiFiles as $key => $currentFile){
	// 		$this->templateFoot .= sprintf($format,$currentFile);
	// 	}//end foreach	
		
	// 	return $this;
	// }//end method

}//end class AppApiUITranslatorMaterialDesign