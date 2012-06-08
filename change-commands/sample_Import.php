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
		return "";
	}

	/**
	 * @return String
	 */
	public function getDescription()
	{
		return "import all samples data";
	}
	
	/**
	 * This method is used to handle auto-completion for this command.
	 * @param Integer $completeParamCount the parameters that are already complete in the command line
	 * @param String[] $params
	 * @param array<String, String> $options where the option array key is the option name, the potential option value or true
	 * @return String[] or null
	 */
//	public function getParameters($completeParamCount, $params, $options, $current)
//	{
//		$components = array();
//		
//		// Generate options in $components.		
//		
//		return $components;
//	}
	
	/**
	 * @param String[] $params
	 * @param array<String, String> $options where the option array key is the option name, the potential option value or true
	 * @return boolean
	 */
//	protected function validateArgs($params, $options)
//	{
//	}

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
		$this->message("== Initdata ==");

		$this->loadFramework();
		
		$parent = $this->getParent();
		$parent->executeCommand('disable-site');
		$parent->executeCommand('theme.install');
		$batchPath = 'modules/sample/lib/bin/batchImport.php';
		
		$samples = $this->getSamples();
		
		$index = 0;
		foreach (array_chunk($samples, 1, true) as $chunk)
		{
			$result = f_util_System::execHTTPScript($batchPath, $chunk);
			// Log fatal errors...
			if ($result != 'OK')
			{
				Framework::error(__METHOD__ . ' ' . $batchPath . ' unexpected result: "' . $result . '"');
				echo "Error: " . $result;
			}
			$index = $index + count($chunk);
			echo "Importing samples: " . $samples[$index - 1] . "\n";
		}
		
		$parent->executeCommand('mysqlstock.reset-products-stock');
		$parent->executeCommand('i18n-synchro');
		$parent->executeCommand('catalog.compile-catalog');
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
		$samples[] = 'loyalty' . DIRECTORY_SEPARATOR . 'sample.xml';
		$samples[] = 'order' . DIRECTORY_SEPARATOR . 'default.xml';
		$samples[] = 'customer' . DIRECTORY_SEPARATOR . 'sample.xml';
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
}