<?php
namespace Api\Classes\Utilities\Filters;
use Api\Classes\Utilities\Filters\AppFilterProfileSanitize as FilterSanitize;
use Api\Classes\Utilities\Filters\AppFilterProfileValidate as FilterValidate;

class AppFilterParameter
extends AppFilters
{
	CONST OPTIONAL_VALUE = [
		FilterSanitize::OPTIONAL_VALUE,
		FilterValidate::OPTIONAL_VALUE
	];
	CONST NAME_GENERIC   = [
		FilterSanitize::NAME_GENERIC,
		FilterValidate::NAME_GENERIC
	];
	CONST ADDRESS_HOME   = [
		FilterSanitize::ADDRESS_HOME,
		FilterValidate::ADDRESS_HOME
	];
	CONST NUMBER_PHONE   = [
		FilterSanitize::NUMBER_PHONE,
		FilterValidate::NUMBER_PHONE
	];
	CONST EMAIL_ADDRESS   = [
		FilterSanitize::EMAIL_ADDRESS,
		FilterValidate::EMAIL_ADDRESS
	];
	CONST EMAIL_SUBJECT   = [
		FilterSanitize::EMAIL_SUBJECT,
		FilterValidate::EMAIL_SUBJECT
	];
	CONST EMAIL_MESSAGE   = [
		FilterSanitize::EMAIL_MESSAGE,
		FilterValidate::EMAIL_MESSAGE
	];
}//end class