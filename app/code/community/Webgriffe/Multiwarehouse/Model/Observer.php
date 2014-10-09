<?php
class Webgriffe_Multiwarehouse_Model_Observer
{

    /**
     * event: catalog_product_save_before
     *
     * @param Varien_Event_Observer $observer
     */
    public function handleMultipleQuantitiesPost(Varien_Event_Observer $observer)
    {
        if (!Mage::app()->getRequest()->isPost()) {
            return;
        }

        /** @var Mage_Catalog_Model_Product $product */
        $product = $observer->getProduct();

        $post = Mage::app()->getRequest()->getPost();

        // if multiple quantity was disabled
        if ($post['wgmulti_original_use_multiple_qty'] == 1 && $post['wgmulti_use_multiple_qty'] == 0)
        {
            Mage::getModel('wgmulti/warehouse_product')
                ->getCollection()
                ->addProductIdFilter($product->getId())
                ->delete();
        }

        // if multiple quantity was enabled
        if ($post['wgmulti_use_multiple_qty'] == 1)
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

    /**
     * event: sales_model_service_quote_submit_success
     */
    public function decrementQuantities(Varien_Event_Observer $observer)
    {
        /** @var Mage_Sales_Model_Order $order */
        $order = $observer->getOrder();

        /** @var Mage_Sales_Model_Order_Item $item */
        foreach ($order->getAllItems() as $item)
        {
            $additionalData = array();
            $serializedAdditionalData = $item->getAdditionalData();
            if (!empty($serializedAdditionalData)) {
                $additionalData = unserialize($serializedAdditionalData);
            }

            $orderedQty = $item->getQtyOrdered();

            $warehouseProducts = Mage::getModel('wgmulti/warehouse_product')
                ->getCollection()
                ->addProductIdFilter($item->getProductId());

            foreach ($warehouseProducts as $warehouseProduct)
            {
                if ($warehouseProduct->getQty() >= $orderedQty) {
                    $warehouseProduct->setQty($warehouseProduct->getQty()-$orderedQty);
                    $additionalData[$warehouseProduct->getWarehouseId()] = $orderedQty;
                    break;
                }
                $additionalData[$warehouseProduct->getWarehouseId()] = $warehouseProduct->getQty();
                $orderedQty -= $warehouseProduct->getQty();
                $warehouseProduct->setQty(0);
            }

            $item->setAdditionalData(serialize($additionalData))->save();

            $warehouseProducts->save();
        }
    }
}