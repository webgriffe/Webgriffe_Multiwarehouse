<?php
class Webgriffe_Multiwarehouse_Block_Adminhtml_Warehouse
    extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_warehouse';
        $this->_blockGroup = 'wgmulti';
        $this->_headerText = $this->__('Manage Warehouses');
        $this->_addButtonLabel = $this->__('Add New Warehouse');
        parent::__construct();
    }

}