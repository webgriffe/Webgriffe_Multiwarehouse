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

}