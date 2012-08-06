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
		return "<core|cms|ecommercecms|itesting>";
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
		$components = array('core', 'cms', 'ecommercecms', 'itesting');
		
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
		return (count($params) == 1 && in_array($params[0], array('core', 'cms', 'ecommercecms', 'itesting')));
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
		$this->updateConfigXML($params[0]);
		$parent->executeCommand('compile-config');
		
		switch ($params[0])
		{
			case 'core' :
				$this->message('= Import samples of your OS Core modules =');
				$wantedSamples = 'sample' . DIRECTORY_SEPARATOR . 'core.xml';
				break;
			case 'cms' :
				$this->message('= Import samples of CMS & Core modules =');
				$wantedSamples = 'sample' . DIRECTORY_SEPARATOR . 'cms.xml';
				break;
			case 'ecommercecms' :
				$this->message('= Import samples of your OS Ecom & Core modules	=');
				$wantedSamples = 'sample' . DIRECTORY_SEPARATOR . 'ecommerce.xml';
				break;
			case 'itesting' :
				$this->message('= Import samples for integration testing =');
				$wantedSamples = 'sample' . DIRECTORY_SEPARATOR . 'itesting.xml';
				break;
			default :
				$this->message('= Import only ' . $params[0] . ' =');
				$wantedSamples = array($params[0]);
		}
		
		$samples = array($wantedSamples);
		
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
	public function updateConfigXML($mode)
	{
		$cs = change_ConfigurationService::getInstance();
		
		switch ($mode)
		{
			case 'ecommercecms' :
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultPageTemplate', 'default/sidebarpageecomsample');
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultNosidebarTemplate', 'default/nosidebarpageecomsample');
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultHomeTemplate', 'default/nosidebarpageecomsample');
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultPopinTemplate', 'default/popin');
				break;
			case 'cms' :
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultPageTemplate', 'default/sidebarpagecmssample');
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultNosidebarTemplate', 'default/nosidebarpagecmssample');
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultHomeTemplate', 'default/nosidebarpagecmssample');
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultPopinTemplate', 'default/popin');
				break;
			default :
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultPageTemplate', 'default/sidebarpage');
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultNosidebarTemplate', 'default/nosidebarpage');
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultHomeTemplate', 'default/nosidebarpage');
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultPopinTemplate', 'default/popin');
				break;
		}
	}
}