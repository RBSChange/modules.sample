<?php
/**
 * @package modules.sample
 */
class sample_Setup extends object_InitDataSetup
{
	public function install()
	{
		$this->addProjectConfigurationEntry('modules/catalog/currentBillingAreaStrategyClass', 'sample_BillingAreaSelectorStrategy');
	}
}