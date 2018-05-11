<?php
namespace Api\Classes\Core\UI;

class AppApiUIOperatorReponse
{
    CONST RESPONSE_TYPE = [
        'RES_NONE'          => 'R000',
        'RES_ERROR_CHECK'   => 'R001',
        'RES_UI_LOAD'       => 'R002',
    ];
    private $type;
    private $definition;

	public function __construct()
	{
		return $this;
    }//end method __construct
    
    public function getType()
    {
        return $type;
    }//end method getType

    public function setType($i)
    {
        if(in_array($i,self::RESPONSE_TYPE)){
            $this->type = $i;
        }else{
            $this->type = self::RESPONSE_TYPE['RES_NONE'];
        }//end method 
        return $this;
    }//end method setType
}//end class AppApiUICheckerDefinition