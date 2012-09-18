<?php
$arguments = isset($arguments) ? $arguments : array();
$samples = $arguments;

$scriptReader = import_ScriptReader::getInstance();

foreach ($samples as $sampleXMLArray)
{
	Framework::info(date_Calendar::getInstance()->toString() . " Import data $sampleXMLArray ...");
	try
	{
		$scriptReader->executeModuleScript('sample', $sampleXMLArray);
		echo 'OK';
	}
	catch (Exception $e)
	{
		echo $e->getMessage();
	}
}