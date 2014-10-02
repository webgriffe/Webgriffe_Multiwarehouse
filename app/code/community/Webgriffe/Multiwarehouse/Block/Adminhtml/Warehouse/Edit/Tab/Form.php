<?php
class Webgriffe_Multiwarehouse_Block_Adminhtml_Warehouse_Edit_Tab_Form
    extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $id = $this->getRequest()->getParam('id');

        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldsetBasic = $form->addFieldset('wgmw_form_general', array('legend' => $this->__('General')));

        if ($id)
        {
            //edit
        }
        else
        {
            //add
        }

        $fieldsetBasic->addField('code', 'text', array(
                'name' => 'code',
                'label' => $this->__('Code'),
                'class' => 'required-entry',
                'required' => true,
            ));

        $fieldsetBasic->addField('name', 'text', array(
                'name' => 'name',
                'label' => $this->__('Name'),
                'class' => 'required-entry',
                'required' => true,
            ));

        $fieldsetBasic->addField('position', 'text', array(
                'name' => 'position',
                'label' => $this->__('Position'),
                'class' => 'required-entry validate-number',
                'required' => true,
            ));

        if (Mage::getSingleton('adminhtml/session')->getData())
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getData());
            Mage::getSingleton('adminhtml/session')->setData(null);
        }
        elseif (Mage::registry('item_data'))
        {
            $form->setValues(Mage::registry('item_data')->getData());
        }

        if ($id)
        {
            //edit
        }
        else
        {
            //add
            $data = array();
            $data['position'] = 1;
            $form->setValues($data);
        }

        return parent::_prepareForm();
    }
}