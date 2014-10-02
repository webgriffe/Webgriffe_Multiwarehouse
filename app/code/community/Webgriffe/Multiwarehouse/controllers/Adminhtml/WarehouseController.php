<?php
class Webgriffe_Multiwarehouse_Adminhtml_WarehouseController
    extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->_title($this->__('Catalog'))
            ->_title($this->__('Manage Warehouses'));

        $this->loadLayout()
            ->_setActiveMenu('catalog/wgmw_warehouses')
            ->_addBreadcrumb($this->__('Items Manager'), $this->__('Item Manager'));

        return $this;
    }

    public function indexAction()
    {
        $this->_initAction();
        $grid = $this->getLayout()->createBlock('wgmw/adminhtml_warehouse', 'wgmwwarehouse');
        $this->_addContent($grid);
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_redirect('*/*/edit');
    }

    public function editAction()
    {
        $itemId = $this->getRequest()->getParam('id');
        $item = Mage::getModel('wgmw/warehouse')->load($itemId);
        if ($item->getId() || $itemId == 0) {
            Mage::register('item_data', $item);
            $this->_initAction();

            $this->_addBreadcrumb($this->__('New Item'), $this->__('New Item'));
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('wgmw/adminhtml_warehouse_edit'))
                ->_addLeft($this->getLayout()->createBlock('wgmw/adminhtml_warehouse_edit_tabs'));

            $this->renderLayout();
        }
        else
        {
            Mage::getSingleton('core/session')->addError($this->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }

    // TODO: Check ACL
    protected function _isAllowed()
    {
        return parent::_isAllowed();
    }

}