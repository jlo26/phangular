<?php
namespace Api\Classes\Core\UI\Translator;
use Api\Classes\Core\UI as AppCoreUI;

class AppApiUITranslator
{
	public $translatedUi;
	private $appUiObj;
	private $templateHead;
	private $templateFoot;

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
		"directive"			 => "<span class='ng-cloak' ng-show='__ERRORSHOW__.::errorModel::'>[che]__ERRORMSG__.::errorModel::[rold]</span>",
	];

	public function __construct(AppCoreUI\AppApiUI $appUiObj)
	{
		$this->appUiObj 	= $appUiObj;
		$this->templateHead = '	
		<!DOCTYPE html>
		<html ng-app="appApiModule">
			<head>
				<title>Hello World</title>
				<link type="text/css" rel="stylesheet" href="client_script_loader.php?type=css&index=ui-default">
				<script type="text/javascript" src="client_script_loader.php?type=js&index=ui-default"></script>
			</head>
			<body class="ng-cloak">';

		$this->templateFoot = '
			</body>			
		</html>
		';
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
}//end class AppApiUITranslator