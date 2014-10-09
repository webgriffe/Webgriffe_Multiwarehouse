<?php
class Webgriffe_Multiwarehouse_Block_Adminhtml_Order
    extends Mage_Adminhtml_Block_Template
{
    protected function _getAllowSymlinks()
    {
        return true;
    }

    public function getOrder()
    {
        return Mage::registry('sales_order');
    }

    public function getItemsCollection()
    {
        return $this->getOrder()->getItemsCollection();
    }

    public function getItemHtml(Mage_Sales_Model_Order_Item $item)
    {
        $warehouses = Mage::getModel('wgmulti/warehouse')
            ->getCollection();
        $warehouseData = $warehouses->toFlatArray();

        $html = '';

        $children = $item->getChildrenItems();

        if (empty($children))
        {
            $children = array($item);
        }

        /** @var Mage_Sales_Model_Order_Item $childItem  */
        foreach ($children as $childItem)
        {
            $serializedAdditionalData = $childItem->getAdditionalData();
            if (empty($serializedAdditionalData)) {
                continue;
            }

            $additionalData = unserialize($serializedAdditionalData);
            if (!count($additionalData)) {
                continue;
            }
            $html .= 'SKU: ' . $childItem->getSku() . '<br/>';
            foreach($additionalData as $id => $qty)
            {
                if ($qty > 0)
                {
                    $html .= sprintf("%s: %s<br/>", $warehouseData[$id]['code'], $qty);
                }
            }
        }
        return $html;
    }


}