<?php
namespace Api\Classes\Core\UI;

class AppApiUI
{
	private $type;
	private $ctrl;
	private $temp;
	private $vars;
	private $event;
	private $checker;

	public function __construct($template)
	{
		$this->type  	= $template['type'];
		$this->ctrl  	= $template['ctrl'];
		$this->temp  	= $template['temp'];
		$this->vars 	= $template['vars'];
		$this->event 	= $template['event'];
		$this->checker 	= $template['checker'];

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

	public function initController($ns)
	{
		$uiCtrlName = $this->getCtrl();
		//Get the folder Name
		$uiCtrlName = $ns.NSEP.$uiCtrlName;
		return new $uiCtrlName();
	}//end method getUIController
}//end class AppApiUI