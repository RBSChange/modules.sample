<?php
class sample_BillingAreaSelectorStrategy
{
	/**
	 * @param catalog_persistentdocument_shop $shop
	 * @return catalog_persistentdocument_billingarea
	 */
	public function getCurrentBillingArea($shop)
	{
		$data = change_Controller::getInstance()->getContext()->getStorage()->read('userBillingAreaSelected');
		if (is_numeric($data))
		{
			$billingArea = DocumentHelper::getDocumentInstanceIfExists($data);
			if ($billingArea instanceof catalog_persistentdocument_billingarea)
			{
				return $billingArea;
			}
			change_Controller::getInstance()->getContext()->getStorage()->write('userBillingAreaSelected', null);
		}
		return null;
	}
}