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

    // Implement validation logic to be called before Admin Panel save action
    public function validate()
    {
        $collection = $this->getCollection()
            ->addFieldToFilter('id', array('neq' => $this->getId()))
            ->addFieldToFilter('code', $this->getCode());
        if ($collection->getSize() > 0) {
            return array(Mage::helper('wgmw')->__('A Warehouse with the same Code already exists'));
        }
        return array();
    }

}