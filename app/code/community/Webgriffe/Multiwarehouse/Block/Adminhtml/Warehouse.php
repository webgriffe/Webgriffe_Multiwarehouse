<?php
class Webgriffe_Multiwarehouse_Block_Adminhtml_Warehouse
    extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_warehouse';
        $this->_blockGroup = 'wgmw';
        $this->_headerText = Mage::helper('wgmw')->__('Manage Warehouses');
        $this->_addButtonLabel = Mage::helper('wgmw')->__('Add');
        parent::__construct();
    }

}