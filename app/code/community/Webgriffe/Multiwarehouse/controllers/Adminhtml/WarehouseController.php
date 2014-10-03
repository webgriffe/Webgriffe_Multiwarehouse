<?php
class Webgriffe_Multiwarehouse_Adminhtml_WarehouseController
    extends Mage_Adminhtml_Controller_Action
{
    /**
     * @return Mage_Adminhtml_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('adminhtml/session');
    }

    protected function _initAction()
    {
        $this->_title($this->__('Catalog'))
            ->_title($this->__('Manage Warehouses'));

        $this->loadLayout()
            ->_setActiveMenu('catalog/wgmulti_warehouses')
            ->_addBreadcrumb($this->__('Items Manager'), $this->__('Item Manager'));

        return $this;
    }

    public function indexAction()
    {
        $this->_initAction();
        $grid = $this->getLayout()->createBlock('wgmulti/adminhtml_warehouse', 'wgmultiwarehouse');
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
        $item = Mage::getModel('wgmulti/warehouse')->load($itemId);
        if ($item->getId() || $itemId == 0) {
            Mage::register('item_data', $item);
            $this->_initAction();

            $this->_addBreadcrumb($this->__('New Item'), $this->__('New Item'));
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('wgmulti/adminhtml_warehouse_edit'))
                ->_addLeft($this->getLayout()->createBlock('wgmulti/adminhtml_warehouse_edit_tabs'));

            $this->renderLayout();
        }
        else
        {
            Mage::getSingleton('core/session')->addError($this->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id')) {
            try {
                $item = Mage::getModel('wgmulti/warehouse');
                $item->setId($this->getRequest()->getParam('id'))
                    ->delete();

                $this->_getSession()->addSuccess($this->__('Item successfully deleted'));
                $this->_redirect('*/*/index');
            } catch (Exception $e) {
                Mage::getSingleton('core/session')->addError($e->getMessage());
                $this->_redirect('*/*/index', array('id' => $this->getRequest()->getParam('id')));
            }
        }

        $this->_redirect('*/*/index');
    }

    public function saveAction()
    {
        $data = $this->getRequest()->getPost();
        if ($data) {
            try
            {
                $item = Mage::getModel('wgmulti/warehouse');

                $item->setIsSaving(true) // needed to avoid getting the associated object id
                    ->setId($this->getRequest()->getParam('id'));

                foreach (array('code','name','position') as $field)
                {
                    $item->setData($field, $data[$field]);
                }

                $errors = $item->validate();

                if (empty($errors))
                {
                    $item->save();

                    $this->_getSession()->addSuccess($this->__('Item successfully saved'));
                    $this->_getSession()->setWarehouseData(false);
                    $this->_redirect('*/*/');
                    return;
                }
                else
                {
                    foreach ($errors as $error)
                    {
                        // Error messages must be set in core/session
                        Mage::getSingleton('core/session')->addError($error);
                    }
                    $this->_getSession()->setWarehouseData($data);
                    $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                    return;
                }
            }
            catch (Exception $e)
            {
                Mage::getSingleton('core/session')->addError($e->getMessage());
                $this->_getSession()->setWarehouseData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    // TODO: Check ACL
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('catalog/wgmulti_warehouses');
    }

}