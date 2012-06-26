<?php
/**
 * sample_BlockBillAreaSelectorAction
 * @package modules.sample.lib.blocks
 */
class sample_BlockBillAreaSelectorAction extends website_BlockAction
{
	/**
	 * @param f_mvc_Request $request
	 * @param f_mvc_Response $response
	 * @return String
	 */
	public function execute($request, $response)
	{
		if ($this->isInBackofficeEdition())
		{
			return website_BlockView::NONE;
		}
	
		$shop = catalog_ShopService::getInstance()->getCurrentShop();
		$billingAreas = $shop->getPublishedBillingAreasArray();
		if (count($billingAreas) > 1)
		{
			$currentBillingArea = $shop->getCurrentBillingArea();
			$request->setAttribute('billingAreas', $billingAreas);
			$request->setAttribute('currentBillingArea', $currentBillingArea->getLabelAsHtml());
			return website_BlockView::INPUT;
		}
		return website_BlockView::NONE;
	}
	
	/**
	 * @param f_mvc_Request $request
	 * @param f_mvc_Response $response
	 * @return String
	 */
	public function executeShopAndBillAreaSelection($request, $response)
	{
 		$billingAreaId = $this->getDocumentIdParameter('billingArea');
 		Controller::getInstance()->getContext()->getStorage()->write('userBillingAreaSelected', $billingAreaId);
 		$shop = catalog_ShopService::getInstance()->getCurrentShop();
 		
 		$shop->getCurrentBillingArea(true);
		return $this->execute($request, $response);
	}
}