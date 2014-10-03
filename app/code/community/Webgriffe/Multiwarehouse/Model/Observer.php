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

        // if multiple quantity was disabled
        if ($post['wgmulti_original_enabled'] == 1 && $post['wgmulti_enabled'] == 0)
        {
            Mage::getModel('wgmulti/warehouse_product')
                ->getCollection()
                ->addProductIdFilter($product->getId())
                ->delete();
        }

        // if multiple quantity was enabled
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
    }

}