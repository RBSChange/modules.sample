<?php
/**
 * @package modules.sample
 */
class commands_sample_Import extends c_ChangescriptCommand
{
	/**
	 * @var string[]
	 */
	protected $validValues = array('core', 'ecomcore', 'full-os', 'full');
	
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
	 *			the parameters that are already complete in the command line
	 * @param string[] $params			
	 * @param array<string, string> $options where the option array key is
	 *			the option name, the potential option value or true
	 * @return string[] or null
	 */
	public function getParameters($completeParamCount, $params, $options, $current)
	{
		return $this->validValues;
	}
	
	/**
	 * @param string[] $params			
	 * @param array<string, string> $options where the option array key is
	 *			the option name, the potential option value or true
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
		// Core modules.
		$samples[] = 'website/website-struct.xml';
		$samples[] = 'media/media-data.xml';
		$samples[] = 'sample/core/users.xml';
		$samples[] = 'workflow/workflow-data.xml';
		$samples[] = 'sample/core/form.xml';
		$samples[] = 'notification/notification-data.xml';
		$samples[] = 'sample/core/contactcard.xml';
		$samples[] = 'list/list-data.xml';
		$samples[] = 'rss/rss-data.xml';
		
		$samples[] = 'sample/core/contents.xml';
		$samples[] = 'sample/core/permissions.xml';
	}
	
	/**
	 * @param string[] $samples
	 */
	protected function addEcomCoreSamples(&$samples)
	{
		$samples[] = 'sample/ecom/theme.xml';
		
		// Core modules.
		$samples[] = 'website/website-struct.xml';
		$samples[] = 'media/media-data.xml';
		$samples[] = 'sample/core/users.xml';
		$samples[] = 'workflow/workflow-data.xml';
		$samples[] = 'sample/core/form.xml';
		$samples[] = 'notification/notification-data.xml';
		$samples[] = 'sample/core/contactcard.xml';
		$samples[] = 'list/list-data.xml';
		$samples[] = 'rss/rss-data.xml';
		
		$samples[] = 'sample/ecom/structure.xml';
		
		// CMS modules.
		$samples[] = 'media/media-data.xml';
		$samples[] = 'videos/videos-data.xml';
		$samples[] = 'sample/fullos/privatemessaging.xml';
		$samples[] = 'sample/fullos/forums.xml';
		$samples[] = 'brand/brand-data.xml';

		// ECOM modules.
		$samples[] = 'shipping/shipping-data.xml';
		$samples[] = 'payment/payment-data.xml';
		//$samples[] = 'paybox/paybox-data.xml';
		$samples[] = 'catalog/catalog-struct.xml';
		$samples[] = 'sample/fullos/customer.xml';
		$samples[] = 'order/order-struct.xml';
		
		$samples[] = 'sample/ecomcore/contents.xml';
		$samples[] = 'sample/ecomcore/permissions.xml';
	}
	
	/**
	 * @param string[] $samples
	 */
	protected function addFullOsSamples(&$samples)
	{
		$samples[] = 'sample/ecom/theme.xml';
		
		// Core modules.
		$samples[] = 'website/website-struct.xml';
		$samples[] = 'media/media-data.xml';
		$samples[] = 'sample/core/users.xml';
		$samples[] = 'workflow/workflow-data.xml';
		$samples[] = 'sample/core/form.xml';
		$samples[] = 'notification/notification-data.xml';
		$samples[] = 'sample/core/contactcard.xml';
		$samples[] = 'list/list-data.xml';
		$samples[] = 'rss/rss-data.xml';
		
		$samples[] = 'sample/ecom/structure.xml';
		
		// CMS modules.
		$samples[] = 'media/media-data.xml';
		$samples[] = 'videos/videos-data.xml';
		$samples[] = 'sharethis/sharethis-data.xml';
		$samples[] = 'sample/fullos/privatemessaging.xml';
		$samples[] = 'sample/fullos/event.xml';
		$samples[] = 'sample/fullos/joboffer.xml';
		$samples[] = 'sample/fullos/photoalbum.xml';
		$samples[] = 'sample/fullos/blog.xml';
		$samples[] = 'sample/fullos/forums.xml';
		$samples[] = 'brand/brand-data.xml';
		$samples[] = 'sample/fullos/statictext.xml';
		
		// ECOM modules.
		$samples[] = 'shipping/shipping-data.xml';
		$samples[] = 'payment/payment-data.xml';
		$samples[] = 'paybox/paybox-data.xml';
		$samples[] = 'catalog/catalog-struct.xml';
		$samples[] = 'sample/fullos/customer.xml';
		$samples[] = 'order/order-struct.xml';
		
		$samples[] = 'sample/fullos/contents.xml';
		$samples[] = 'sample/fullos/permissions.xml';
	}
	
	/**
	 * @param string[] $samples
	 */
	protected function addFullSamples(&$samples)
	{
		$samples[] = 'sample/ecom/theme.xml';
		
		// Core modules.
		$samples[] = 'website/website-struct.xml';
		$samples[] = 'media/media-data.xml';
		$samples[] = 'sample/core/users.xml';
		$samples[] = 'workflow/workflow-data.xml';
		$samples[] = 'sample/core/form.xml';
		$samples[] = 'notification/notification-data.xml';
		$samples[] = 'sample/core/contactcard.xml';
		$samples[] = 'list/list-data.xml';
		$samples[] = 'rss/rss-data.xml';
		
		$samples[] = 'sample/ecom/structure.xml';
		
		// CMS modules.
		$samples[] = 'media/media-data.xml';
		$samples[] = 'videos/videos-data.xml';
		$samples[] = 'sharethis/sharethis-data.xml';
		$samples[] = 'sample/fullos/privatemessaging.xml';
		$samples[] = 'sample/fullos/event.xml';
		$samples[] = 'sample/fullos/joboffer.xml';
		$samples[] = 'sample/fullos/photoalbum.xml';
		$samples[] = 'sample/fullos/blog.xml';
		$samples[] = 'sample/fullos/forums.xml';
		$samples[] = 'brand/brand-data.xml';
		$samples[] = 'sample/fullos/statictext.xml';
		
		// ECOM modules.
		$samples[] = 'shipping/shipping-data.xml';
		$samples[] = 'payment/payment-data.xml';
		$samples[] = 'paybox/paybox-data.xml';
		$samples[] = 'catalog/catalog-struct.xml';
		$samples[] = 'sample/fullos/customer.xml';
		$samples[] = 'order/order-struct.xml';
		
		// Non-OS modules.
		$samples[] = 'marketing/marketing-data.xml';
		$samples[] = 'ecomextended/ecomextended-data.xml';
		$samples[] = 'ecomextended/ecomextended-struct.xml';
		$samples[] = 'sample/full/emailing.xml';
		$samples[] = 'sample/full/store.xml';
		$samples[] = 'loyalty/loyalty-struct.xml';
		
		$samples[] = 'sample/full/contents.xml';
		$samples[] = 'sample/full/permissions.xml';
	}
	
	/**
	 * @param string[] $params			
	 * @param array<string, string> $options where the option array key is
	 *			the option name, the potential option value or true
	 * @see c_ChangescriptCommand::parseArgs($args)
	 */
	public function _execute($params, $options)
	{
		$this->message("== Initdata ==");
		
		$this->loadFramework();
		

		$this->executeCommand('disable-site');
		$this->executeCommand('theme.install');
		$batchPath = 'modules/sample/lib/bin/batchImport.php';
		
		// Update config
		$this->updateConfigXML($params[0]);
		$this->executeCommand('compile-config');
		
		$samples = array();
		switch ($params[0])
		{
			case 'core':
				$this->message('= Import samples of your OS Core modules =');
				$this->addCoreSamples($samples);
				break;
			case 'ecomcore':
				$this->message('= Import samples of your OS Ecom Core modules =');
				$this->addEcomCoreSamples($samples);
				break;
			case 'full-os':
				$this->message('= Import samples of all OS modules =');
				$this->addFullOsSamples($samples);
				break;
			case 'full':
				$this->message('= Import samples of all modules	=');
				$this->addFullSamples($samples);
				break;
			/*case 'itesting':
				$this->message('= Import samples for integration testing =');
				$samples[] = 'sample/itesting.xml';
				break;*/
			default:
				$this->message('= Import only ' . $params[0] . ' =');
				$samples[] = $params[0];
		}
		
		$ms = ModuleService::getInstance();
		
		foreach ($samples as $sampleName)
		{
			$moduleName = preg_replace('/\/.*/', '', $sampleName);
			if ($ms->isInstalled($moduleName))
			{
				$result = f_util_System::execScript($batchPath, array($sampleName));
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
				$this->executeCommand('mysqlstock.reset-products-stock');
			}
			$this->executeCommand('catalog.compile');
		}
		
		$this->executeCommand('enable-site');
		
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
			case 'full':
			case 'full-os':
			case 'ecomcore':
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
			default:
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultPageTemplate', 'default/sidebarpage');
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultNosidebarTemplate', 'default/nosidebarpage');
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultHomeTemplate', 'default/nosidebarpage');
				$cs->addProjectConfigurationEntry('modules/website/sample/defaultPopinTemplate', 'default/popin');
				break;
		}
	}
}