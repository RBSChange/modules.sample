<?php
/**
 * @package modules.sample
 */
class sample_ModuleService extends ModuleBaseService
{
	/**
	 * Singleton
	 * @var sample_ModuleService
	 */
	private static $instance = null;

	/**
	 * @return sample_ModuleService
	 */
	public static function getInstance()
	{
		if (is_null(self::$instance))
		{
			self::$instance = self::getServiceClassInstance(get_class());
		}
		return self::$instance;
	}
}