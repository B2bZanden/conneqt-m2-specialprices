<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 11-01-18
 * Time: 17:20
 */

namespace Conneqt\SpecialPrices\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    /**
     *
     *
     * @param \Magento\Framework\Setup\SchemaSetupInterface $setup
     * @param \Magento\Framework\Setup\ModuleContextInterface $context
     * @return void
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        if (!$installer->tableExists('conneqt_specialprices')) {
            $transactionsTable = $installer->getConnection()->newTable(
                $installer->getTable('conneqt_specialprices')
            )
                ->addColumn(
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'Special Price Entity ID'
                )
                ->addColumn(
                    'product_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'nullable' => true
                    ],
                    'Product ID'
                )
                ->addColumn(
                    'customer_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'nullable' => true
                    ],
                    'Customer ID'
                )
                ->addColumn(
                    'type',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    1,
                    [
                        'nullable' => false
                    ],
                    'Special Price Type'
                )
                ->addColumn(
                    'value',
                    \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    '12,4',
                    [
                        'nullable' => true
                    ],
                    'Special Price Value'
                )
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    [
                        'nullable' => false,
                        'default'  => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
                    ],
                    'Created at'
                )
                ->addColumn(
                    'updated_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    [
                        'nullable' => false,
                        'default'  => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE
                    ],
                    'Updated at'
                )
                ->setComment('Conneqt Special Prices Table');

            $installer->getConnection()->createTable($transactionsTable);
        }

        $installer->endSetup();
    }
}