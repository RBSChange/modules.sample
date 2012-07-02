<?php
/**
 * commands_sample_Import
 * @package modules.sample.command
 */
class commands_sample_Import extends commands_AbstractChangeCommand
{
	/**
	 * @return String
	 */
	public function getUsage()
	{
		return "<os-core|os-ecom|ecom-extended|all>";
	}

	/**
	 * @return String
	 */
	public function getDescription()
	{
		return "import samples data";
	}
	
	/**
	 * This method is used to handle auto-completion for this command.
	 * @param Integer $completeParamCount the parameters that are already complete in the command line
	 * @param String[] $params
	 * @param array<String, String> $options where the option array key is the option name, the potential option value or true
	 * @return String[] or null
	 */
	public function getParameters($completeParamCount, $params, $options, $current)
	{
		$components = array('os-core', 'os-ecom', 'ecom-extended', 'all');	
		
		return $components;
	}
	
	/**
	 * @param String[] $params
	 * @param array<String, String> $options where the option array key is the option name, the potential option value or true
	 * @return boolean
	 */
	protected function validateArgs($params, $options)
	{
		return (count($params) == 1);
	}

	/**
	 * @return String[]
	 */
//	public function getOptions()
//	{
//	}

	/**
	 * @param String[] $params
	 * @param array<String, String> $options where the option array key is the option name, the potential option value or true
	 * @see c_ChangescriptCommand::parseArgs($args)
	 */
	public function _execute($params, $options)
	{
		if (count(array_diff($params, array('os-core', 'os-ecom', 'ecom-extended', 'all'))) > 0)
		{
			$this->quitError('Bad parameter');
			$this->message('Usage: change.php ' . $this->getFullName() . ' ' . $this->getUsage());
			return;
		}
		
		$this->message("== Initdata ==");

		$this->loadFramework();
		
		$parent = $this->getParent();
		$parent->executeCommand('disable-site');
		$parent->executeCommand('theme.install');
		$batchPath = 'modules/sample/lib/bin/batchImport.php';
		
		$ecomMode = true;
		
		switch ($params[0])
		{
			case 'os-core':
				$this->message('= Import samples of your OS Core modules =');
				$samples = $this->getOSCoreSamples();
				$ecomMode = false;
				break;
			case 'os-ecom':
				$this->message('= Import samples of your OS Ecom & Core modules =');
				$samples = $this->getOSEcomSamples();
				break;
			case 'ecom-extended':
				$this->message('= Import samples of your OS Core, Ecom & Ecom Extended modules =');
				$samples = $this->getEcomExtSamples();
				break;
			case 'all':
				$this->message('= Import samples of all your modules =');
				$samples = $this->getSamples();
				break;
			default:
				$samples = array();
		}
		
		$ms = ModuleService::getInstance();
		
		$index = 0;
		foreach (array_chunk($samples, 1, true) as $chunk)
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
		$parent->executeCommand('i18n-synchro');
		if ($ecomMode && $ms->isInstalled('catalog'))
		{
			if ($ms->isInstalled('mysqlstock'))
			{
				$parent->executeCommand('mysqlstock.reset-products-stock');
			}
			$parent->executeCommand('catalog.compile-catalog');
			
			$this->message("Replace default page templates by eCom page templates");
			$tps = theme_PagetemplateService::getInstance();
			$tps->replacePagetemplate($tps->getByCodeName('default/nosidebarpage'), $tps->getByCodeName('default/nosidebarpage-ecom'));
			$tps->replacePagetemplate($tps->getByCodeName('default/sidebarpage'), $tps->getByCodeName('default/sidebarpage-ecom'));
		}
		$parent->executeCommand('enable-site');
		
		$this->quitOk("Command successfully executed");
	}
	
	/**
	 * @return string[]
	 */
	private function getSamples()
	{
		$samples = array();
		
		$samples[] = 'website' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'media' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'photoalbum' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'users' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'workflow' . DIRECTORY_SEPARATOR . 'sample.xml';
		
		$samples[] = 'emailing' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'emailing' . DIRECTORY_SEPARATOR . 'samplepage.xml';
		
		$samples[] = 'forums' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'blog' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'form' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'download' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'notification' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'contactcard' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'list' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'faq' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'lexicon' . DIRECTORY_SEPARATOR . 'sample.xml';
		
		$samples[] = 'survey' . DIRECTORY_SEPARATOR . 'sample.xml';
		
		$samples[] = 'inquiry' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'joboffer' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'sharethis' . DIRECTORY_SEPARATOR . 'sample.xml';
		
		$samples[] = 'ads' . DIRECTORY_SEPARATOR . 'sample.xml';
		
		$samples[] = 'videos' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'polls' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'statictext' . DIRECTORY_SEPARATOR . 'sample.xml';
		
		$samples[] = 'brand' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'shipping' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'payment' . DIRECTORY_SEPARATOR . 'sample.xml';
		
		$samples[] = 'atosserver' . DIRECTORY_SEPARATOR . 'sample.xml';
		
		$samples[] = 'paybox' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'catalog' . DIRECTORY_SEPARATOR . 'default.xml';
		$samples[] = 'catalog' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'customer' . DIRECTORY_SEPARATOR . 'default.xml';
		$samples[] = 'order' . DIRECTORY_SEPARATOR . 'default.xml';
		$samples[] = 'customer' . DIRECTORY_SEPARATOR . 'sample.xml';
		
		$samples[] = 'loyalty' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'marketing' . DIRECTORY_SEPARATOR . 'sample.xml';
		
		$samples[] = 'order' . DIRECTORY_SEPARATOR . 'sample.xml';
		
		$samples[] = 'privatesales' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'productreturns' . DIRECTORY_SEPARATOR . 'sample.xml';
		
		$samples[] = 'event' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'rss' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'bookmarks' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'privatemessaging' . DIRECTORY_SEPARATOR . 'sample.xml';
		
		$samples[] = 'mobileapps' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'store' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'store' . DIRECTORY_SEPARATOR . 'sampleextranet.xml';
		$samples[] = 'synchronizer' . DIRECTORY_SEPARATOR . 'sample.xml';
		
		return $samples;
	}
	
	/**
	 * @return string[]
	 */
	private function getOSCoreSamples()
	{
		$samples = array();
		
		$samples[] = 'website' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'media' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'users' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'workflow' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'form' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'notification' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'contactcard' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'list' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'statictext' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'rss' . DIRECTORY_SEPARATOR . 'sample.xml';
		
		return $samples;
	}
	
	/**
	 * @return string[]
	 */
	private function getOSEcomSamples()
	{
		$samples = $this->getOSCoreSamples();
		
		$samples[] = 'brand' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'shipping' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'payment' . DIRECTORY_SEPARATOR . 'sample.xml';
		
		$samples[] = 'paybox' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'catalog' . DIRECTORY_SEPARATOR . 'default.xml';
		$samples[] = 'catalog' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'customer' . DIRECTORY_SEPARATOR . 'default.xml';
		$samples[] = 'order' . DIRECTORY_SEPARATOR . 'default.xml';
		$samples[] = 'customer' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'order' . DIRECTORY_SEPARATOR . 'sample.xml';
		
		return $samples;
	}
	
	/**
	 * @return string[]
	 */
	private function getEcomExtSamples()
	{
		$samples = $this->getOSEcomSamples();
		
		return $samples;
	}
	
	private function getAllSamples()
	{
		$samples = $this->getEcomExtSamples();
		$samples[] = 'photoalbum' . DIRECTORY_SEPARATOR . 'sample.xml';
		
		return $samples;
	}	
	
}