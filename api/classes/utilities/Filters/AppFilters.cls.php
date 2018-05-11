<?php
namespace Api\Classes\Utilities\Filters;

class AppFilters
{

	CONST INPUT_SANITIZER = [
		"CLEAN_EMAIL" 			=> FILTER_SANITIZE_EMAIL,
		"CLEAN_ENCODING" 		=> FILTER_SANITIZE_ENCODED,
		"CLEAN_MAGIC_QUOTES" 	=> FILTER_SANITIZE_MAGIC_QUOTES,
		"CLEAN_NUM_FLOAT" 		=> FILTER_SANITIZE_NUMBER_FLOAT,
		"CLEAN_NUM_INT" 		=> FILTER_SANITIZE_NUMBER_INT,
		"CLEAN_SPEC_CHARS"      => FILTER_SANITIZE_SPECIAL_CHARS,
		"CLEAN_SPEC_CHARS_FULL" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
		"CLEAN_STRING" 			=> FILTER_SANITIZE_STRING,
		"CLEAN_STRIPPED" 		=> FILTER_SANITIZE_STRIPPED,
		"CLEAN_URL" 			=> FILTER_SANITIZE_URL,
		"CLEAN_RAW" 			=> FILTER_UNSAFE_RAW,
	];

	CONST INPUT_VALIDATORS = [
		"IS_BOOL"   => FILTER_VALIDATE_BOOLEAN,
		"IS_DOMAIN" => FILTER_VALIDATE_DOMAIN,
		"IS_EMAIL" 	=> FILTER_VALIDATE_EMAIL,
		"IS_FLOAT" 	=> FILTER_VALIDATE_FLOAT,
		"IS_INT" 	=> FILTER_VALIDATE_INT,
		"IS_IP" 	=> FILTER_VALIDATE_IP,
		"IS_MAC" 	=> FILTER_VALIDATE_MAC,
		"IS_REGEX" 	=> FILTER_VALIDATE_REGEXP,
		"IS_URL" 	=> FILTER_VALIDATE_URL,
		"IS_ANY" 	=> '',
	];

	public static $invalidValueList = array();
	public static $validValueList   = array();

	private static function inputSanitize($inputs,$filterArray)
	{
		$retInput = "";

		if(count($filterArray) > 0){
			foreach($filterArray as $inKey => $currSanitizer){
				$inputs = filter_var($inputs,$currSanitizer);
			}//end inner foreach
		}//endif
		
		$retInput = $inputs;

		return $retInput;
	}//end method

	/*
	 *	Validate array of inputs using 
	 *	1D array of input sanitazion types
	 */
	private static function inputValidate($input,$validator)
	{
		$validatorInd = '';
		$currentInput = $input;
		if(trim($validator) !== ''){
			return filter_var($currentInput,$validator);
		}//endif
		return TRUE;
	}//end method

	public static function executeValidation(
		array $inputList,
		array $filterParam,
		$sanitize = FALSE
	)
	{
		$validator   = '';
		$sanitizer   = [];
		$invalidList = [];
		$index = 0;

		foreach($inputList as $key => $currVal){

			$sanitizer = $filterParam[$key][0];
			$validator = $filterParam[$key][1];

			$resSanitize = $currVal;
			if($sanitize){
				$resSanitize  = self::inputSanitize($currVal,$sanitizer);
			}//endif
			$resValidation = self::inputValidate($resSanitize,$validator);

			if(FALSE === $resValidation){
				$i = $index++;
				$invalidList[$i]["key"]   = $key;
				$invalidList[$i]["value"] = $currVal;
				self::$invalidValueList["key"] = $currVal;
			}else{
				self::$validValueList[$key] = $resSanitize;
			}//endif
		}//end foreach

		return $invalidList;
	}//end method 

}//end class WrightUtilities