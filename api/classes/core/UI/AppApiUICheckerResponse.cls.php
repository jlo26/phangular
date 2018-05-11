<?php
namespace Api\Classes\Core\UI;

class AppApiUICheckerResponse
{
    /*If checking has/has no error*/
    private $checkingResult; 
    /*If checking has error, how the error should be displayed*/
    private $errorDisplayType;
    private $variableCount;
    private $testedVariableCount;
    private $resultCountValid;
    private $resultCountInvalid;
    private $errorMessages;
    private $invalidModelList;

    private $testedVariable;
    private $validInput;
    private $invalidInput;

    public function __construct()
    {
        $this->testedVariable = 0;
        $this->validInput     = 0;
        $this->invalidInput   = 0;
        $this->errorMessages  = [];
        $this->invalidModelList  = [];
        return $this->setDefaultResponse();
    }//end method __construct

    public function __call($fxName,$val)
	{
		$operation = substr($fxName,0,3);
		$fxName    = substr($fxName,3);
		$propName  = lcfirst($fxName);
		if(property_exists($this, $propName)){
			if(strtolower(trim($operation)) == 'set'){
				$this->$propName = $val[0];
				return $this;
			}else{
				return $this->$propName;
			}//endif
		}//end if
    }//end method

    public function setCheckerResult()
    {
        $this->setCheckingResult((count($this->invalidInput) > 0));              
        $this->setTestedVariableCount($this->testedVariable);
        $this->setResultCountValid($this->validInput);
        $this->setResultCountInvalid($this->invalidInput);
    }//end method setCheckerResult

    public function setErrors($variableName,$message)
    {
        $this->errorMessages[$variableName] = $message;
        return $this;
    }//end method setCheckerError 
  
    public function addInvalidModel($modelName)
    {
        $this->invalidModelList[] = $modelName;
    }//end method

    public function addInvalidInput($modelName)
    {
        $this->addInvalidModel($modelName);
        $this->invalidInput++;
        return $this;
    }//end method addInvalidInput

    public function addValidInput()
    {
        $this->validInput++;
        return $this;
    }//end method addValidInput

    public function addTestedVariable()
    {
        $this->testedVariable++;
        return $this;
    }//end method addTestedVariable

    private function setDefaultResponse()
    {
        $this->setCheckingResult(AppApiUIChecker::CHECKING_RESULT['DEFINITION_ERROR']);
        $this->setErrorDisplayType(AppApiUIChecker::ERROR_DISPLAY['ALL_TOP']);
        $this->setVariableCount(0);
        $this->setTestedVariableCount(0);
        $this->setResultCountValid(0);
        $this->setResultCountInvalid(0);

        return $this;
    }//end method setDefaultResponse

    public function toClientResponse()
    {
        $varList = get_class_vars (__CLASS__);
        $return = [];
        foreach ($varList as $propName => $currentProp) {
            $return[$propName] = $this->$propName;
        }//end foreach

        return $return;
    }//end method __toString
}//end class AppApiUICheckerResponse