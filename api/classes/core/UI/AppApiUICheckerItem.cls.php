<?php
namespace Api\Classes\Core\UI;

class AppApiUICheckerItem
{
    private $mode;
    private $manualChecker;
    private $autoChecker;
    private $definition;

	public function __construct(array $autoCheckerDefinition = [])
	{
        $this->definition = $autoCheckerDefinition;
        return $this->initialize();
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

    private function initialize()
    {
        $this->extractMode();
        $this->extractManualChecker();
        $this->extractAutoChecker();
        $this->definition = NULL;
        return $this;
    }//end method initialize

    private function extractMode()
    {
        $index = AppApiUIChecker::LEVEL_FIELDS['VARIABLE']['I3'];

        if(isset($this->definition[$index])){
            $this->mode = $this->definition[$index];
        }else{
            $this->mode = AppApiUIChecker::DEFAULT_SETUP['CHECKING_MODE'];
        }//endif

        return $this;
    }//end method getAutoChecker

    private function extractManualChecker()
    {
        $index = AppApiUIChecker::LEVEL_FIELDS['VARIABLE']['I1'];
        if(isset($this->definition[$index])){
            $this->manualChecker = $this->definition[$index];
        }else{
            $this->manualChecker = AppApiUIChecker::DEFAULT_SETUP['CHECKING_MODE'];
        }//endif

        return $this;
    }//end method getAutoChecker

    private function extractAutoChecker()
    {
        $index          = AppApiUIChecker::LEVEL_FIELDS['VARIABLE']['I2'];
        $autoCheckerObj = new AppApiUICheckerItemAutomatic();       

        if(isset($this->definition[$index])){

            $autoCheckerObj->setDefinition($this->definition[$index]);
            $autoCheckerObj->extractValidationDefinition();
        }else{

            $autoCheckerObj->setDefaultValidation();
        }//endif
        
        $this->autoChecker = $autoCheckerObj;

        return $this;
    }//end method getAutoChecker
    
}//end class AppApiUICheckerItemAutomatic