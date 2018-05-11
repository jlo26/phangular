<?php
namespace Api\Classes\Core;

class AppApiClientScriptLoader
{
	private static $filePathCSS;
	private static $filePathJS;

	public static function addCSSFile($file)
	{
		self::$filePathCSS[] = $file;
	}//end method addCSSFile

	public static function addCSSArrayFile(array $file)
	{
		self::$filePathCSS = $file;
	}//end method addCSSFile

	public static function addJSFile($file)
	{
		self::$filePathJS[] = $file;
	}//end method

	public static function addJSArrayFile(array $file)
	{
		self::$filePathJS = $file;
	}//end method

	public static function loadJSFiles()
	{
		$fileContent = '';
		
		foreach(self::$filePathJS as $key => $currentFile){
			$fileContent .= file_get_contents($currentFile);
		}//end foreach
		
		return $fileContent;
	}//end method loadJSFiles
	
	public static function loadCSSFiles()
	{
		$fileContent = '';
		
		foreach(self::$filePathCSS as $key => $currentFile){
			$fileContent .= file_get_contents($currentFile);
		}//end foreach

		return $fileContent;
	}//end method loadJSFiles
}//end class AppApiClientScriptLoader