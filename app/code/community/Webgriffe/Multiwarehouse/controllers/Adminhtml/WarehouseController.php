<?php
class Webgriffe_Multiwarehouse_Adminhtml_WarehouseController
    extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('catalog/wgmw_warehouses')
            ->_addBreadcrumb(Mage::helper('wgmw')->__('Items Manager'), Mage::helper('wgmw')->__('Item Manager'));
        $grid = $this->getLayout()->createBlock('wgmw/adminhtml_warehouse', 'wgmwwarehouse');
        $this->_addContent($grid);
        $this->renderLayout();
    }

    // TODO: Check ACL
    protected function _isAllowed()
    {
        return parent::_isAllowed();
    }

}