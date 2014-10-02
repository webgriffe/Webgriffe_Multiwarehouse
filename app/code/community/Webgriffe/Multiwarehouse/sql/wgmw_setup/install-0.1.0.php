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
    ->newTable($installer->getTable('wgmw/warehouse'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary'  => true,
        ), 'ID')
    ->addColumn('code', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255,
        array(
            'nullable' => false
        ), 'Code')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255,
        array(
            'nullable' => false
        ), 'Name')
    ->addColumn('position', Varien_Db_Ddl_Table::TYPE_SMALLINT, 6,
        array(
            'nullable' => false
        ), 'Sort position')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null,
        array(), 'Creation Time')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null,
        array(), 'Modification Time')
    ->setComment('Warehouse Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();