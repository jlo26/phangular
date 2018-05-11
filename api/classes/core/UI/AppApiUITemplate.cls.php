<?php
namespace Api\Classes\Core\UI;

class AppApiUITemplate
{
	const UI_JOINED     	= 'UI001';
	const UI_STANDALONE 	= 'UI002';
	const TEMPLATE_FIELDS 	= ['ctrl','temp','vars','event','type','checker'];

	public static function init(array $template)
	{
		return self::checkNeededFields($template);
	}//end method 

	public static function standAlone(array $template)
	{
		$template['type'] = self::UI_STANDALONE;
		return self::checkNeededFields($template);
	}//end method standAlone

	public static function joined(array $template)
	{
		$template['type'] = self::UI_JOINED;		
		return self::checkNeededFields($template);
	}//end method joined

	private static function checkNeededFields(array $template)
	{
		$reqTemplateFields = self::TEMPLATE_FIELDS;
		foreach($reqTemplateFields as $key => $neededField) {
			if(!array_key_exists($neededField, $template)){
				return FALSE;
			}//end 
		}//end foreach

		return new AppApiUI($template);
	}//end method checkNeededFields
}//end class