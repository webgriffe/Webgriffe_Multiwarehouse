<?php
class Webgriffe_Multiwarehouse_Block_Adminhtml_Qty
    extends Mage_Adminhtml_Block_Template
{
    protected function _getAllowSymlinks()
    {
        return true;
    }

    public function getProduct()
    {
        return Mage::registry('product');
    }

    public function getIsEnabled()
    {
        $productId = $this->getProduct()->getId();
        if ($productId)
        {
            $warehouseProductColl = Mage::getModel('wgmulti/warehouse_product')
                ->getCollection()
                ->addProductIdFilter($productId);

            return $warehouseProductColl->getSize() > 0;
        }
        return false;
    }

    public function getWarehouses(){
        $ret = array();

        foreach (Mage::getModel('wgmulti/warehouse')->getCollection()->setOrder('position', 'asc') as $wh) {
            $ret[$wh->getId()] = $wh->getData();
            $ret[$wh->getId()]['qty'] = 0;
        }

        $productId = $this->getProduct()->getId();
        if ($productId)
        {
            $warehouseProductColl = Mage::getModel('wgmulti/warehouse_product')
                ->getCollection()
                ->addProductIdFilter($productId);

            foreach ($warehouseProductColl as $relation) {
                $ret[$relation->getWarehouseId()]['qty'] = $relation->getQty();
            }
        }

        return $ret;
    }

    public function formatDecimal($val)
    {
        if ($this->getProduct()->getStockItem() && $this->getProduct()->getStockItem()->getIsQtyDecimal()) {
            return sprintf("%.2F", $val);
        }
        return sprintf("%d", $val);
    }
}