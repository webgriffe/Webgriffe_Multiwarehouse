<?php
class Webgriffe_Multiwarehouse_Block_Adminhtml_Warehouse_Edit_Tabs
    extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();

        $this->setId('warehouse_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle($this->__('Item Details'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
                'label' => $this->__('Warehouse'),
                'title' => $this->__('Warehouse'),
                'content' => $this->getLayout()->createBlock('wgmw/adminhtml_warehouse_edit_tab_form')->toHtml(),
            ));

        return parent::_beforeToHtml();
    }
}