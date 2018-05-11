<?php
namespace Api\Classes\Core\UI;

class AppApiUICheckerDefinition
extends AppApiUIChecker
{


    private $items;
    private $errorChecking;
    private $errorDisplay;

	public function __construct(array $checkerDefinition, array $variableList)
	{
        $this->definition   = $checkerDefinition;
        $this->variableList = $variableList;
        $this->createCheckerItems();
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
 
    public function getErrorChecking()
    {
        $index = AppApiUIChecker::LEVEL_FIELDS['CORE']['I1'];
        if(
            isset($this->definition[$index]) && 
            in_array($this->definition[$index], AppApiUIChecker::CHECKING_MODE)
        ){
            $this->errorChecking = $this->definition[$index];
        }else{
            $this->errorChecking = AppApiUIChecker::DEFAULT_SETUP['CHECKING_MODE'];
        }//endif

        return $this->errorChecking;
    }//end method getMode

    public function getErrorDisplay()
    {
        $index = parent::LEVEL_FIELDS['CORE']['I2'];
        if(
            isset($this->definition[$index]) && 
            in_array($this->definition[$index], AppApiUIChecker::ERROR_DISPLAY)
        ){
            $this->errorDisplay = $this->definition[$index];
        }else{
            $this->errorDisplay = AppApiUIChecker::DEFAULT_SETUP['ERROR_DISPLAY'];
        }//endif

        return $this->errorDisplay;
    }//end method getErrorDisplay

    public function getItems()
    {
        return $this->items;
    }//end method getItems

    public function createCheckerItems()
    {
        $index = AppApiUIChecker::LEVEL_FIELDS['CORE']['I3'];

        $variableList = $this->variableList;
        $checkerItems = $this->definition[$index];

        foreach($variableList as $key => $currentVariable){
            
            if(isset($checkerItems[$currentVariable])){
                $this->items[$currentVariable] = new AppApiUICheckerItem(
                    $checkerItems[$currentVariable]
                );
            }//endif
        }//end foreach
        
        $this->definition = NULL;
        return $this;
    }//end method extractItems

}//end class AppApiUICheckerDefinition