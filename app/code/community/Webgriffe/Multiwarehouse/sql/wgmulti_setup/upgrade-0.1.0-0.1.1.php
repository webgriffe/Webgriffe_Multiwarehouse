<?php
/**
 * Created by PhpStorm.
 * User: alessandro
 * Date: 10/2/14
 * Time: 4:25 PM
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('wgmulti/warehouse_product'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary'  => true,
        ), 'ID')
    ->addColumn('warehouse_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'unsigned' => true,
            'nullable' => false
        ), 'Warehouse ID')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'unsigned' => true,
            'nullable' => false
        ), 'Product ID')
    ->addColumn('qty', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4',
        array(
            'nullable' => false
        ), 'Product Quantity')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null,
        array(), 'Creation Time')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null,
        array(), 'Modification Time')
    ->addForeignKey(
        /* fkName */    $installer->getFkName('wgmulti/warehouse_product', 'id', 'wgmulti/warehouse', 'id'),
        /* column */    'warehouse_id',
        /* refTable */  $installer->getTable('wgmulti/warehouse'),
        /* refColumn */ 'id',
        /* onDelete*/   Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        /* fkName */    $installer->getFkName('wgmulti/warehouse_product', 'id', 'catalog/product', 'entity_id'),
        /* column */    'product_id',
        /* refTable */  $installer->getTable('catalog/product'),
        /* refColumn */ 'entity_id',
        /* onDelete*/   Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Warehouse Product relation');
$installer->getConnection()->createTable($table);

$installer->endSetup();