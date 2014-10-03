<?php
class Webgriffe_Multiwarehouse_Model_Observer
{

    public function handleMultipleQuantitiesPost(Varien_Event_Observer $observer)
    {
        if (!Mage::app()->getRequest()->isPost()) {
            return;
        }

        /** @var Mage_Catalog_Model_Product $product */
        $product = $observer->getProduct();

        $post = Mage::app()->getRequest()->getPost();
        if ($post['wgmulti_original_enabled'] == 1 && $post['wgmulti_enabled'] == 0)
        {
            Mage::getModel('wgmulti/warehouse_product')
                ->getCollection()
                ->addProductIdFilter($product->getId())
                ->delete();
        }

        if ($post['wgmulti_enabled'] == 1)
        {
            $totalQty = 0.0;
            foreach ($post['wgmultiqty'] as $warehouseId => $qty)
            {
                Mage::getModel('wgmulti/warehouse_product')
                    ->getCollection()
                    ->addWarehouseIdFilter($warehouseId)
                    ->addProductIdFilter($product->getId())
                    ->getFirstItem() // if doesn't exist, return new object
                    ->setWarehouseId($warehouseId)
                    ->setProductId($product->getId())
                    ->setQty($qty)
                    ->save();
                $totalQty += $qty;
            }
            $product->getStockItem()->setQty($totalQty);
        }

        Zend_Debug::setSapi('cli');

        $debug = Zend_Debug::dump($product->debug(), 'PRODUCT', 0);
        Mage::log($debug, null, 'wgmulti.log', true);

        $debug = Zend_Debug::dump($post, 'POST', 0);
        Mage::log($debug, null, 'wgmulti.log', true);
    }

}