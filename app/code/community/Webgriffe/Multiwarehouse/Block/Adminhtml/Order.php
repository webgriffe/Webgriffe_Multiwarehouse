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
            if (empty($serializedAdditionalData))
            {
                continue;
            }

            $additionalData = unserialize($serializedAdditionalData);
            if (!count($additionalData))
            {
                continue;
            }

            foreach($additionalData as $id => $qty)
            {
                if ($qty > 0)
                {
                    $html .= '<tr class="border"><td>' . $childItem->getSku() . '</td>';
                    $html .= sprintf(
                        "<td><a href=\"%s\">%s</a></td><td class=\"a-center\">%s</td>",
                        $this->getUrl('wgmulti/adminhtml_warehouse/edit', array('id' => $id)),
                        $warehouseData[$id]['code'],
                        $this->_formatQty($qty, $childItem->getIsQtyDecimal()));
                    $html .= '</tr>';
                }
            }
        }
        return $html;
    }

    protected function _formatQty($qty, $isDecimal)
    {
        if ($isDecimal) {
            return round($qty, 2);
        }

        return intval($qty);
    }


}