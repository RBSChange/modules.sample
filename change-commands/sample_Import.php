<?php
/**
 * commands_sample_Import
 * @package modules.sample.command
 */
class commands_sample_Import extends commands_AbstractChangeCommand
{
	/**
	 *
	 * @return String
	 */
	public function getUsage()
	{
		return "<core|cms|ecommercecms>";
	}
	
	/**
	 *
	 * @return String
	 */
	public function getDescription()
	{
		return "import samples data";
	}
	
	/**
	 * This method is used to handle auto-completion for this command.
	 *
	 * @param Integer $completeParamCount
	 *        	the parameters that are already complete in the command line
	 * @param String[] $params        	
	 * @param
	 *        	array<String, String> $options where the option array key is
	 *        	the option name, the potential option value or true
	 * @return String[] or null
	 */
	public function getParameters($completeParamCount, $params, $options, $current)
	{
		$components = array('core', 'cms', 'ecommercecms');
		
		return $components;
	}
	
	/**
	 *
	 * @param String[] $params        	
	 * @param
	 *        	array<String, String> $options where the option array key is
	 *        	the option name, the potential option value or true
	 * @return boolean
	 */
	protected function validateArgs($params, $options)
	{
		return (count($params) == 1 && in_array($params[0], array('core', 'cms', 'ecommercecms')));
	}
	
	/**
	 *
	 * @param String[] $params        	
	 * @param
	 *        	array<String, String> $options where the option array key is
	 *        	the option name, the potential option value or true
	 * @see c_ChangescriptCommand::parseArgs($args)
	 */
	public function _execute($params, $options)
	{
		$this->message("== Initdata ==");
		
		$this->loadFramework();
		
		$parent = $this->getParent();
		$parent->executeCommand('disable-site');
		$parent->executeCommand('theme.install');
		$batchPath = 'modules/sample/lib/bin/batchImport.php';
		
		// Update config
		$this->updateConfigXML();
		$parent->executeCommand('compile-config');
		
		switch ($params[0])
		{
			case 'core' :
				$this->message('= Import samples of your OS Core modules =');
				$wantedSamples = $this->getOSCoreSamples();
				break;
			case 'cms' :
				$this->message('= Import samples of CMS & Core modules =');
				$wantedSamples = $this->getCMSSamples();
				break;
			case 'ecommercecms' :
				$this->message('= Import samples of your OS Ecom & Core modules	=');
				$wantedSamples = $this->getOSEcomSamples();
				break;
			default :
				$this->message('= Import only ' . $params[0] . ' =');
				$wantedSamples = array($params[0]);
		}
		
		$samples = $wantedSamples;
		
		$ms = ModuleService::getInstance();
		
		$index = 0;
		foreach (array_chunk($samples, 1, false) as $chunk)
		{
			$sampleName = $samples[$index];
			$moduleName = preg_replace('/\/.*/', '', $sampleName);
			if ($ms->isInstalled($moduleName))
			{
				$result = f_util_System::execHTTPScript($batchPath, $chunk);
				// Log fatal errors...
				if ($result != 'OK')
				{
					Framework::error(__METHOD__ . ' ' . $batchPath . ' unexpected result: "' . $result . '"');
					$this->errorMessage("Error: " . $result);
				}
				$this->message("Importing samples: " . $sampleName);
			}
			else
			{
				$this->warnMessage('Sample: ' . $sampleName . ' wasn\'t imported because module ' . $moduleName . ' is not installed');
			}
			$index++;
		}
		if ($ms->isInstalled('catalog'))
		{
			if ($ms->isInstalled('mysqlstock'))
			{
				$parent->executeCommand('mysqlstock.reset-products-stock');
			}
			$parent->executeCommand('catalog.compile-catalog');
		}
		
		$parent->executeCommand('enable-site');
		
		$this->quitOk("Command successfully executed");
	}
	
	/**
	 * update project.xml
	 */
	public function updateConfigXML()
	{
		$file = WEBEDIT_HOME . '/config/project.xml';
		
		$doc = f_util_DOMUtils::fromPath($file);
		
		$nodeWebsite = $doc->findUnique('//project/config/modules/website');
		
		if ($nodeWebsite == NULL)
		{
			$nodeModules = $doc->findUnique('//project/config/modules');
			$newNode = $doc->createElement("website");
			$nodeModules->appendChild($newNode);
		}
		
		$nodeSample = $doc->findUnique('//project/config/modules/website/sample');
		
		if ($nodeSample == NULL)
		{
			$nodeWebsite = $doc->findUnique('//project/config/modules/website');
			$newNode = $doc->createElement("sample");
			$nodeWebsite->appendChild($newNode);
			
			$nodeSample = $doc->findUnique('//project/config/modules/website/sample');
			
			$nameTemplate = array('defaultPageTemplate' => 'default/sidebarpageecomsample', 
				'defaultNosidebarTemplate' => 'default/nosidebarpageecomsample', 'defaultHomeTemplate' => 'default/nosidebarpageecomsample');
			
			foreach ($nameTemplate as $key => $value)
			{
				$newTextNode = $doc->createTextNode($value);
				
				$newNode = $doc->createElement("entry");
				$newNode->setAttribute('name', $key);
				$newNode->appendChild($newTextNode);
				
				$nodeSample->appendChild($newNode);
			}
		}
		
		$doc->save($file);
	}
	
	
	
	/**
	 * @return string[]
	 */
	private function getOSCoreSamples()
	{
		$samples = array();
		
		$samples[] = 'sample' . DIRECTORY_SEPARATOR . 'samplecore.xml';
		
		return $samples;
	}
	
	/**
	 * @return string[]
	 */
	private function getOSEcomSamples()
	{
		$samples = $this->getOSCoreSamples();
		
		$samples[] = 'sample' . DIRECTORY_SEPARATOR . 'sampleecommerce.xml';
		
		return $samples;
	}
	
	/**
	 * @return string[]
	 */
	private function getCMSSamples()
	{
		$samples = $this->getOSCoreSamples();
		
		$samples[] = 'sample' . DIRECTORY_SEPARATOR . 'samplecms.xml';
		
		return $samples;
	}
	
}