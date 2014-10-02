<?php
/**
 * Created by PhpStorm.
 * User: alessandro
 * Date: 10/2/14
 * Time: 4:32 PM
 */ 
class Webgriffe_Multiwarehouse_Model_Warehouse extends Mage_Core_Model_Abstract
{

    protected function _beforeSave()
    {
        $this->setUpdatedAt(Mage::getSingleton('core/date')->gmtDate());
        if ($this->isObjectNew() && null === $this->getCreatedAt()) {
            $this->setCreatedAt(Mage::getSingleton('core/date')->gmtDate());
        }
        return parent::_beforeSave();
    }

    protected function _construct()
    {
        $this->_init('wgmw/warehouse');
    }

}