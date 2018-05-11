<?php
namespace Api\Classes\Core\UI;

class AppApiUIChecker
{

	CONST LEVEL_FIELDS = [
		'CORE'			=> ['I1' => 'errorChecking'	,'I2' => 'errorDisplay'	,'I3' => 'items'],
		'VARIABLE'		=> ['I1' => 'manualChecker'	,'I2' => 'autoChecker'	,'I3' => 'mode'],
		'CHECKER_ITEM'	=> ['I1' => 'validation'	,'I2' => 'errorMessage'],
		'AUTOCHECKER'	=> [
			 'I1' 	=> 'type'
			,'I2' 	=> 'min'
			,'I3'	=> 'max'
			,'I4'	=> 'regex'
		],
	];

	CONST CHECKING_RESULT = [
		'WITH_ERROR'		=> 1,
		'NO_ERROR'			=> 2,
		'DEFINITION_ERROR'	=> 3,
	];
	CONST CHECKING_MODE = [
        'BOTH'		    =>  0,
        'MANUAL_ONLY'	=>  1,
        'AUTO_ONLY'		=>  2,
    ];
    CONST ERROR_DISPLAY = [
        'ALL_TOP'       =>  0,
        'LINE_MESSAGE'  =>  1,
        'ALERT_POPUP'   =>  2,
	];

	CONST DEFAULT_SETUP = [
        'CHECKING_MODE'  => self::CHECKING_MODE['AUTO_ONLY'],
        'ERROR_DISPLAY'  => self::ERROR_DISPLAY['ALL_TOP'],
    ];
    private $definition;
	private $variableList;
    private $variableValueList;
    private $checkerResponseObj;
    private $appUiCtrlObj;

	public function __construct(
		 array $checkerDefinition
		,array $variableList
		,array $variableValueList
		,AppApiUIController $appUiCtrlObj
	)
	{
		$this->definition   	= $checkerDefinition;
		$this->variableList 	= $variableList;
		$this->variableValueList= $variableValueList['data'];
		$this->appUiCtrlObj		= $appUiCtrlObj;

		$this->checkerResponseObj = new AppApiUICheckerResponse();
		return $this;
	}//end method __construct

	public function executeInputChecking()
	{
		$currentCheckerItemObj = NULL;
		if($this->validateDefinition()){
			
			$varList 			= $this->variableValueList;
			$apiUICheckerDefObj = $this->getCheckerDefinitionItems();
			$checkerItemObj 	= $apiUICheckerDefObj->getItems();
			$checkingMode		= NULL;

			foreach ($varList as $currentVariable => $variableValue) {
				//If variable is set for checking, disregard if not
				if(isset($checkerItemObj[$currentVariable])){

					$currentCheckerItemObj 	= $checkerItemObj[$currentVariable];
					$checkingMode 			= $currentCheckerItemObj->getMode();					
					$this->checkerResponseObj->addTestedVariable();

					switch($checkingMode){
						case self::CHECKING_MODE['BOTH']: 
							$validationPassed = $this->checkingAutoOnly(
								$currentCheckerItemObj,
								$currentVariable,
								$variableValue
							);
							
							// Do the manual validation if auto validation 
							// has no error
							if($validationPassed){
								$this->checkingManualOnly(
									$currentCheckerItemObj,
									$currentVariable,
									$variableValue
								);
							}//endif
							break;

						case self::CHECKING_MODE['MANUAL_ONLY']: 
							$this->checkingManualOnly(
								$currentCheckerItemObj,
								$currentVariable,
								$variableValue
							);
							break;

						case self::CHECKING_MODE['AUTO_ONLY']: 
							$this->checkingAutoOnly(
								$currentCheckerItemObj,
								$currentVariable,
								$variableValue
							);
							break;
					}//end switch
				}//endif
			}//end foreach
		}//endif

		//Update with the operation result
		$this->checkerResponseObj
			->setVariableCount(count($varList))
			->setErrorDisplayType($apiUICheckerDefObj->getErrorDisplay())
			->setCheckerResult();

		return $this->checkerResponseObj;
	}//end method executeInputChecking

	private function getCheckerDefinitionItems()
	{
		return new AppApiUICheckerDefinition(
			 $this->definition
			,$this->variableList
		);
	}//end method getDefinition

	private function checkingAutoOnly(
		AppApiUICheckerItem $currentCheckerItemObj,
		$varName,
		$varValue
	)
	{
		
		$checkerItemObj  = $currentCheckerItemObj->getAutoChecker();
		$value 	= $varValue;
		$type 	= $checkerItemObj->getType();
		$min	= $checkerItemObj->getMin();
		$max 	= $checkerItemObj->getMax();
		$regEx  = $checkerItemObj->getRegex();
		$result = FALSE;
		$length = strlen(trim($value));

		// Check Data type
		switch($type){
			case AppApiUICheckerItemTypes::CT_STRING:
					$result = is_string($value);
				break;
			case AppApiUICheckerItemTypes::CT_INTEGER: 	
					$result = is_int($value);
				break;
			case AppApiUICheckerItemTypes::CT_FLOAT:	
					$result = is_float($value);
				break;
			case AppApiUICheckerItemTypes::CT_BOOLEAN: 	
					$result = is_bool($value);
				break;
		}//end switch

		if(!$result){
			$this->checkerResponseObj->addInvalidInput($varName);
			$this->checkerResponseObj->setErrors(
				$varName,
				$checkerItemObj->getErrorType()
			);

			return FALSE;
		}//endif

		//Check Length
		if($length < $min){
			$this->checkerResponseObj->addInvalidInput($varName);
			$this->checkerResponseObj->setErrors(
				$varName,
				$checkerItemObj->getErrorMin()
			);

			return FALSE;
		}//endif

		if($length > $max){
			$this->checkerResponseObj->addInvalidInput($varName);
			$this->checkerResponseObj->setErrors(
				$varName,$checkerItemObj->getErrorMax()
			);

			return FALSE;
		}//endif

		//Check using regex
		if(trim($regEx) !== ''){
			preg_match($regEx, $value, $matches, PREG_OFFSET_CAPTURE);
			if(count($matches) <= 0){
				$this->checkerResponseObj->addInvalidInput($varName);
				$this->checkerResponseObj->setErrors(
					$varName,
					$checkerItemObj->getErrorRegex()
				);
				return FALSE;
			}//endif
		}//endif
		
		$this->checkerResponseObj->addValidInput();
		return TRUE;
	}//end method checkingAutoOnly

	public function checkingManualOnly(
		AppApiUICheckerItem $currentCheckerItemObj
		,$varName
		,$varValue
	)
	{
		$manualCheckerMethodName  = $currentCheckerItemObj->getManualChecker();
		/** 
		 * the format of the result should be an array 
		 * $result['valid'] = boolean
		 * $result['error'] = string
		 */
		$result = call_user_func_array(array(
			$this->appUiCtrlObj,
			$manualCheckerMethodName),
			[$varName,$varValue]
		);

		if(!$result['valid']){
			$this->checkerResponseObj->setErrors($varName,$result['error']);
			$this->checkerResponseObj->addInvalidInput($varName);
			return FALSE;
		}//endif

		$this->checkerResponseObj->addValidInput();
		return TRUE;
	}//end method 

	/* Ensures the needed fields are given correctly*/
	public function validateDefinition()
	{
		$validLevelEntry 	= $this->checkCoreFields();
		$indexItems 		= self::LEVEL_FIELDS['CORE']['I3'];
		$indexVariableAC	= self::LEVEL_FIELDS['VARIABLE']['I2'];
		$indexValidation	= self::LEVEL_FIELDS['CHECKER_ITEM']['I1'];
		$indexErrorMessage	= self::LEVEL_FIELDS['CHECKER_ITEM']['I2'];
		$variableItems 		= [];
		$autoCheckerItems 	= [];
		$validationItems 	= [];
		
		if($validLevelEntry){
			$variableItems = $this->definition[$indexItems];

			foreach ($variableItems as $currentVariable => $variableDefinition) {
				$currentVariable = trim($currentVariable);
				/* Extract only the item with equivalent variable */
				if(
					in_array($currentVariable, $this->variableList) &&
					$this->checkVariableFields($variableDefinition)
				){

					/* Check checker item fields*/
					$autoCheckerItems = $variableDefinition[$indexVariableAC];
					if($this->checkCheckerItemFields($autoCheckerItems)){

						$validationItems[0] = $autoCheckerItems[$indexValidation];
						$validationItems[1] = $autoCheckerItems[$indexErrorMessage];

						if(!(
							$this->checkAutoCheckerFields($validationItems[0]) &&
							$this->checkAutoCheckerFields($validationItems[1])
						)){
							return FALSE;
						}//endif

					}else{
						return FALSE;
					}//endif
				}else{
					return FALSE;
				}//endif
			}//end foreach
		}else{
			return FALSE;
		}//endif

		return TRUE;
	}//end method validateDefinition

	private function checkCoreFields()
	{
		return $this->formatChecker(
			$this->definition,
			self::LEVEL_FIELDS['CORE']
		);
	}//end method checkCoreFields

	private function checkVariableFields(array $definition)
	{
		return $this->formatChecker(
			$definition,
			self::LEVEL_FIELDS['VARIABLE']
		);
	}//end method checkCoreFields

	private function checkCheckerItemFields(array $definition)
	{
		return $this->formatChecker(
			$definition,
			self::LEVEL_FIELDS['CHECKER_ITEM']
		);
	}//end method checkAutoCheckerFields

	private function checkAutoCheckerFields(array $definition)
	{
		return $this->formatChecker(
			$definition,
			self::LEVEL_FIELDS['AUTOCHECKER']
		);
	}//end method checkAutoCheckerFields
	
	private function formatChecker(array $definition, array $format)
	{
		foreach ($definition as $definitionKey => $value) {
			if(!in_array($definitionKey, $format)){

				return FALSE;
			}//endif
		}//end foreach

		return TRUE;
	}//end method 
}//end class AppApiUIChecker