<?php
/**
 * Created by PhpStorm.
 * User: alessandro
 * Date: 10/3/14
 * Time: 10:06 AM
 */ 
class Webgriffe_Multiwarehouse_Model_Resource_Warehouse_Product_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('wgmulti/warehouse_product');
    }

    public function addProductIdFilter($productId)
    {
        return $this->addFieldToFilter('product_id', $productId);
    }

    public function addWarehouseIdFilter($warehouseId)
    {
        return $this->addFieldToFilter('warehouse_id', $warehouseId);
    }

    /**
     * Delete all the entities in the collection
     */
    public function delete()
    {
        foreach ($this->getItems() as $k => $item)
        {
            $item->delete($item);
            unset($this->_items[$k]);
        }
        return $this;
    }

}