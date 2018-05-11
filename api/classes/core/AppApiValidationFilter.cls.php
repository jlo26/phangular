<?php
namespace Api\Classes\Core;

class AppApiValidationFilter
{

	private $filterParam;
	public function __construct(array $filterParam)
	{
		$this->setFilterParam($filterParam);
		
		return $this;
	}//end method __construct

	public function setFilterParam($i)
	{
		$this->filterParam = $i;
		return $this;
	}//end method 

	public function getFilterParam()
	{
		return $this->filterParam;
	}//end method
}
