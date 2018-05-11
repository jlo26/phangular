<?php
namespace Api\Classes\Utilities\Filters;

class AppFilterProfileValidate
extends AppFilters
{
	CONST OPTIONAL_VALUE   	= self::INPUT_VALIDATORS['IS_ANY'];
	CONST NAME_GENERIC     	= self::INPUT_VALIDATORS['IS_ANY'];
	CONST ADDRESS_HOME     	= self::INPUT_VALIDATORS['IS_ANY'];
	CONST NUMBER_PHONE     	= self::INPUT_VALIDATORS['IS_INT'];
	CONST EMAIL_ADDRESS    	= self::INPUT_VALIDATORS['IS_EMAIL'];
	CONST EMAIL_SUBJECT  	= self::INPUT_VALIDATORS['IS_ANY'];
	CONST EMAIL_MESSAGE  	= self::INPUT_VALIDATORS['IS_ANY'];
}//end class