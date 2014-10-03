<?php
class Webgriffe_Multiwarehouse_Block_Adminhtml_Warehouse_Grid
    extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct($attributes = array())
    {
        parent::__construct($attributes);

        $this->setId('warehousegrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $this->setCollection(Mage::getModel('wgmulti/warehouse')->getCollection());
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        // ID
        $this->addColumn('id', array(
            'header'    => $this->__('ID'),
            'index'     => 'id',
        ));

        // Code
        $this->addColumn('code', array(
            'header'    => $this->__('Code'),
            'index'     => 'code',
        ));

        // Name
        $this->addColumn('name', array(
            'header'    => $this->__('Name'),
            'index'     => 'name',
        ));

        // Position
        $this->addColumn('position', array(
            'header'    => $this->__('Position'),
            'index'     => 'position',
        ));

        // Created at
        $this->addColumn('created_at', array(
            'header'    => $this->__('Created at'),
            'type'      => 'datetime',
            'index'     => 'created_at',
            'gmtoffset' => true
        ));

        // Updated at
        $this->addColumn('updated_at', array(
            'header'    => $this->__('Last updated'),
            'type'      => 'datetime',
            'index'     => 'updated_at',
            'gmtoffset' => true
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($item)
    {
        return $this->getUrl('*/*/edit', array('id' => $item->getId()));
    }
}