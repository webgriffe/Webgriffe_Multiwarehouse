<?php
class Webgriffe_Multiwarehouse_Block_Adminhtml_Warehouse_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_warehouse';
        $this->_blockGroup = 'wgmulti';
        $this->_updateButton('save', 'label', $this->__('Save'));
        $this->_updateButton('delete', 'label', $this->__('Delete'));
    }

    public function getHeaderText()
    {
        if (Mage::registry('item_data') && Mage::registry('item_data')->getId())
        {
            return $this->__(sprintf("Edit Item (%d)", Mage::registry('item_data')->getId()));
        }
        else
        {
            return $this->__('Add Item');
        }
    }
}