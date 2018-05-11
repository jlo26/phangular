<?php
namespace Api\Classes\Core\UI;

class AppApiUICheckerItemAutomatic
{
    CONST VALIDATION_TYPE   = ['type','min','max','regex'];
    CONST DEFAULT_SETUP     = [
        'TYPE'  => 'DT_STRING',
        'MIN'   => 0,
        'MAX'   => 50,
        'REGEX' => NULL,
        'ERROR_MESSAGE' => [
            'TYPE'  => '*Invalid type entered!',
            'MIN'   => '*Input is less than the minimum value!',
            'MAX'   => '*Input is greater than the maximum value!',
            'REGEX' => '*',
        ]
    ];
    
    private $type;
    private $min;
    private $max;
    private $regex;
    private $errorType;
    private $errorMin;
    private $errorMax;
    private $errorRegex;
    private $definition;

	public function __construct(array $autoCheckerDefinition = [])
	{
        $this->definition = (count($autoCheckerDefinition) > 0)? $autoCheckerDefinition: NULL;
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

    public function extractValidationDefinition()
    {
        $errorPropName  = '';
        $definition     = $this->definition[0];
        $validationList = self::VALIDATION_TYPE;
        $index['val']   = trim(AppApiUIChecker::LEVEL_FIELDS['CHECKER_ITEM']['I1']);
        $index['err']   = trim(AppApiUIChecker::LEVEL_FIELDS['CHECKER_ITEM']['I2']);

        foreach ($validationList as $key => $validation) {
            $validation     = strtolower(trim($validation));
            $errorPropName  = 'error'.ucfirst($validation);
            
            if(
                isset($definition[$index['val']][$validation]) &&
                isset($definition[$index['err']][$validation])
                ){

                $this->$validation      = $definition[$index['val']][$validation];
                $this->$errorPropName   = $definition[$index['err']][$validation];
            }else{
                $this->$validation      = self::DEFAULT_SETUP[strtoupper($validation)];
                $this->$errorPropName   = self::DEFAULT_SETUP['ERROR_MESSAGE'][strtoupper($validation)];
            }//endif
        }//end foreach
        
        $this->definition = NULL;
        return $this;
    }//end method 

    public function setDefaultValidation()
    {
        $this->setType(self::DEFAULT_SETUP['TYPE']);
        $this->setMin(self::DEFAULT_SETUP['MIN']);
        $this->setMax(self::DEFAULT_SETUP['MAX']);
        $this->setRegex(self::DEFAULT_SETUP['REGEX']);

        $this->setErrorType(self::DEFAULT_SETUP['ERROR_MESSAGE']['TYPE']);
        $this->setErrorMin(self::DEFAULT_SETUP['ERROR_MESSAGE']['MIN']);
        $this->setErrorMax(self::DEFAULT_SETUP['ERROR_MESSAGE']['MAX']);
        $this->setErrorRegex(self::DEFAULT_SETUP['ERROR_MESSAGE']['REGEX']);

        return $this;
    }//end method getDefaultValidationDefinition
    
    
}//end class AppApiUICheckerItemAutomatic