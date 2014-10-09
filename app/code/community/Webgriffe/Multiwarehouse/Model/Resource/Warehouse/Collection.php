<?php
/**
 * Created by PhpStorm.
 * User: alessandro
 * Date: 10/2/14
 * Time: 4:32 PM
 */ 
class Webgriffe_Multiwarehouse_Model_Resource_Warehouse_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('wgmulti/warehouse');
    }

    public function toFlatArray()
    {
        $arrItems = array();
        foreach ($this as $item) {
            $arrItems[$item->getId()] = $item->getData();
        }
        return $arrItems;
    }

}