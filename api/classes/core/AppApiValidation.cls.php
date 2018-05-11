<?php
namespace Api\Classes\Core;
use Api\Classes\Utilities\Filters as AppUtil;

class AppApiValidation
{

	private $inputFilterParam;
	private $appValidFilter;
	public  static $validInputs;
	public  static $invalidInputs;

	public function __construct(AppApiValidationFilter $appValidation)
	{
		$this->appValidFilter = $appValidation;
		return $this;
	}//end method __construct

	public function validateParam(array $argsToFilter, $sanitize = FALSE){
		$args = $argsToFilter;
		if(count($args) > 0){
			self::$invalidInputs = AppUtil\AppFilters::executeValidation(
				$args,
				$this->appValidFilter->getFilterParam(),
				$sanitize
			);

			self::$validInputs = AppUtil\AppFilters::$validValueList;
			return self::$invalidInputs;
		}//endif

		return FALSE;
	}//end method 

}
