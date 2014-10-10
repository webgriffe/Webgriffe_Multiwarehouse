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

    public function getWarehouseFlatArray()
    {
        $warehouses = Mage::getModel('wgmulti/warehouse')
            ->getCollection()
            ->addOrder('position', 'ASC');
        return $warehouses->toFlatArray();
    }

    public function getItemHtml(Mage_Sales_Model_Order_Item $item)
    {
        $warehouseData = $this->getWarehouseFlatArray();

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

            $tmpHtml = '<tr class="border"><td>'.$childItem->getSku().'</td>';
            $tmpCount = 0;
            foreach ($warehouseData as $wid => $wdata)
            {
                $qty = 0;
                if (array_key_exists($wid, $additionalData))
                {
                    $qty = $additionalData[$wid];
                }
                $tmpCount += $qty;
                $qty = $this->_formatQty($qty, $childItem->getIsQtyDecimal());

                $tmpHtml .= '<td>' . $qty . '</td>';
            }
            if ($tmpCount) {
                $html .= $tmpHtml;
            }
            $html .= '</tr>';
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