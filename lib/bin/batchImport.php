<?php
if (!defined("WEBEDIT_HOME"))
{
	define("WEBEDIT_HOME", realpath('.'));
	require_once WEBEDIT_HOME . "/framework/Framework.php";
	$samples = array_slice($_SERVER['argv'], 1);
}
else
{
	$samples = $_POST['argv'];
}

$scriptReader = import_ScriptReader::getInstance();

foreach ($samples as $sampleXMLArray)
{
	Framework::info(date_Calendar::getInstance()->toString() . " Import data $sampleXMLArray ...");
	$scriptReader->executeModuleScript('sample', $sampleXMLArray);
}

echo 'OK';