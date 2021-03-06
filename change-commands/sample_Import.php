<?php
/**
 * @package modules.sample
 */
class commands_sample_Import extends commands_AbstractChangeCommand
{
	/**
	 * @var string[]
	 */
	protected $validValues = array('core', 'full-os', 'full');
	
	/**
	 * @return string
	 */
	public function getUsage()
	{
		return '<' . implode('|', $this->validValues) . '>';
	}
	
	/**
	 * @return string
	 */
	public function getDescription()
	{
		return "import samples data";
	}
	
	/**
	 * This method is used to handle auto-completion for this command.
	 *
	 * @param integer $completeParamCount
	 *        	the parameters that are already complete in the command line
	 * @param string[] $params        	
	 * @param array<string, string> $options where the option array key is
	 *        	the option name, the potential option value or true
	 * @return string[] or null
	 */
	public function getParameters($completeParamCount, $params, $options, $current)
	{
		return $this->validValues;
	}
	
	/**
	 * @param string[] $params        	
	 * @param array<string, string> $options where the option array key is
	 *        	the option name, the potential option value or true
	 * @return boolean
	 */
	protected function validateArgs($params, $options)
	{
		return (count($params) == 1 && in_array($params[0], $this->validValues));
	}
	
	/**
	 * @param string[] $samples
	 */
	protected function addCoreSamples(&$samples)
	{
		$samples[] = 'sample/core/permissions.xml';
		$samples[] = 'sample/core/theme.xml';
		
		// Core modules.
		$samples[] = 'sample/core/website.xml';
		$samples[] = 'sample/core/structure.xml';
		
		$samples[] = 'sample/core/media.xml';
		$samples[] = 'sample/core/users.xml';
		$samples[] = 'sample/core/workflow.xml';
		$samples[] = 'sample/core/form.xml';
		$samples[] = 'sample/core/notification.xml';
		$samples[] = 'sample/core/contactcard.xml';
		$samples[] = 'sample/core/list.xml';
		$samples[] = 'sample/core/rss.xml';
		
		$samples[] = 'sample/core/contents.xml';
	}
	
	/**
	 * @param string[] $samples
	 */
	protected function addFullOsSamples(&$samples)
	{
		$samples[] = 'sample/fullos/permissions.xml';
		$samples[] = 'sample/fullos/theme.xml';
		
		// Core modules.
		$samples[] = 'sample/core/website.xml';
		$samples[] = 'sample/fullos/structure.xml';
		
		$samples[] = 'sample/core/media.xml';
		$samples[] = 'sample/core/users.xml';
		$samples[] = 'sample/core/workflow.xml';
		$samples[] = 'sample/core/form.xml';
		$samples[] = 'sample/core/notification.xml';
		$samples[] = 'sample/core/contactcard.xml';
		$samples[] = 'sample/core/list.xml';
		$samples[] = 'sample/core/rss.xml';
		
		// OS modules
		// CMS modules.
		$samples[] = 'sample/fullos/sharethis.xml';
		$samples[] = 'sample/fullos/inquiry.xml';
		
		$samples[] = 'sample/fullos/blog.xml';
		$samples[] = 'sample/fullos/event.xml';
		$samples[] = 'sample/fullos/forums.xml';
		$samples[] = 'sample/fullos/privatemessaging.xml';
		$samples[] = 'sample/fullos/polls.xml';
		$samples[] = 'sample/fullos/videos.xml';
		$samples[] = 'sample/fullos/photoalbum.xml';
		
		$samples[] = 'sample/fullos/joboffer.xml';
		$samples[] = 'sample/fullos/statictext.xml';
		$samples[] = 'sample/fullos/bookmarks.xml';
		
		// ECOM modules.
		$samples[] = 'sample/fullos/brand.xml';
		$samples[] = 'sample/fullos/shipping.xml';
		$samples[] = 'sample/fullos/payment.xml';
		$samples[] = 'sample/fullos/paybox.xml';
		$samples[] = 'sample/fullos/catalog.xml';
		$samples[] = 'sample/fullos/customer.xml';
		$samples[] = 'sample/fullos/order.xml';
		$samples[] = 'sample/fullos/kiala.xml';
		$samples[] = 'sample/fullos/mondialrelay.xml';
		$samples[] = 'sample/fullos/icirelais.xml';
		$samples[] = 'sample/fullos/relaiscolis.xml';
		
		$samples[] = 'sample/fullos/contents.xml';
	}
	
	/**
	 * @param string[] $samples
	 */
	protected function addFullSamples(&$samples)
	{
		$samples[] = 'sample/full/permissions.xml';
		$samples[] = 'sample/fullos/theme.xml';
		
		// Core modules.
		$samples[] = 'sample/core/website.xml';
		$samples[] = 'sample/full/structure.xml';
		
		$samples[] = 'sample/core/media.xml';
		$samples[] = 'sample/core/users.xml';
		$samples[] = 'sample/core/workflow.xml';
		$samples[] = 'sample/core/form.xml';
		$samples[] = 'sample/core/notification.xml';
		$samples[] = 'sample/core/contactcard.xml';
		$samples[] = 'sample/core/list.xml';
		$samples[] = 'sample/core/rss.xml';
		
		// OS modules
		// CMS modules.
		$samples[] = 'sample/fullos/sharethis.xml';
		$samples[] = 'sample/fullos/inquiry.xml';
		
		$samples[] = 'sample/fullos/blog.xml';
		$samples[] = 'sample/fullos/event.xml';
		$samples[] = 'sample/fullos/forums.xml';
		$samples[] = 'sample/fullos/privatemessaging.xml';
		$samples[] = 'sample/fullos/polls.xml';
		$samples[] = 'sample/fullos/videos.xml';
		$samples[] = 'sample/fullos/photoalbum.xml';
		
		$samples[] = 'sample/fullos/joboffer.xml';
		$samples[] = 'sample/fullos/statictext.xml';
		$samples[] = 'sample/fullos/bookmarks.xml';
		
		// ECOM modules.
		$samples[] = 'sample/fullos/brand.xml';
		$samples[] = 'sample/fullos/shipping.xml';
		$samples[] = 'sample/fullos/payment.xml';
		$samples[] = 'sample/fullos/paybox.xml';
		$samples[] = 'sample/fullos/catalog.xml';
		$samples[] = 'sample/fullos/customer.xml';
		$samples[] = 'sample/fullos/order.xml';
		$samples[] = 'sample/fullos/kiala.xml';
		$samples[] = 'sample/fullos/mondialrelay.xml';
		$samples[] = 'sample/fullos/icirelais.xml';
		$samples[] = 'sample/fullos/relaiscolis.xml';
		
		// Non-OS modules.
		$samples[] = 'sample/full/marketing.xml';
		$samples[] = 'sample/full/ecomextended.xml';
		$samples[] = 'sample/full/emailing.xml';
		$samples[] = 'sample/full/store.xml';
		$samples[] = 'sample/full/loyalty.xml';
		$samples[] = 'sample/full/productreturns.xml';
		$samples[] = 'sample/full/support.xml';
		$samples[] = 'sample/full/privatesales.xml';
		$samples[] = 'sample/full/atosserver.xml';
		
		$samples[] = 'sample/full/contents.xml';
	}
	
	/**
	 * @param string[] $params
	 * @param array<string, string> $options where the option array key is the option name, the potential option value or true
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
		
		$samples = array();
		switch ($params[0])
		{
			case 'core' :
				$this->message('= Import samples of your OS Core modules =');
				$this->addCoreSamples($samples);
				break;
			case 'full-os' :
				$this->message('= Import samples of all OS modules =');
				$this->addFullOsSamples($samples);
				break;
			case 'full' :
				$this->message('= Import samples of all modules	=');
				$this->addFullSamples($samples);
				break;
			/*case 'itesting':
				$this->message('= Import samples for integration testing =');
				$samples[] = 'sample/itesting.xml';
				break;*/
			default :
				$this->message('= Import only ' . $params[0] . ' =');
				$samples[] = $params[0];
		}
		
		$ms = ModuleService::getInstance();
		
		foreach ($samples as $sampleName)
		{
			$moduleName = preg_replace('/\/.*/', '', $sampleName);
			if ($ms->isInstalled($moduleName))
			{
				$result = f_util_System::execScriptConsole($batchPath, array($sampleName));
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
	 * @param string $mode
	 */
	public function updateConfigXML($mode)
	{
		$cs = change_ConfigurationService::getInstance();
		switch ($mode)
		{
			case 'full' :
			case 'full-os' :
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultPageTemplate', 'default/sidebarpageecomsample');
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultNosidebarTemplate', 'default/nosidebarpageecomsample');
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultHomeTemplate', 'default/nosidebarpageecomsample');
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultPopinTemplate', 'default/popin');
				break;
			/*case 'cms' :
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultPageTemplate', 'default/sidebarpagecmssample');
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultNosidebarTemplate', 'default/nosidebarpagecmssample');
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultHomeTemplate', 'default/nosidebarpagecmssample');
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultPopinTemplate', 'default/popin');
				break;*/
			default :
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultPageTemplate', 'default/sidebarpage');
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultNosidebarTemplate', 'default/nosidebarpage');
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultHomeTemplate', 'default/nosidebarpage');
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultPopinTemplate', 'default/popin');
				break;
		}
	}
}