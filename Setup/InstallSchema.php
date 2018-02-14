<?php
/**
 * News
 * 
 * @author Slava Yurthev
 */
namespace SY\News\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface {
	public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) {
		$setup->startSetup();

		$table = $setup->getConnection()->newTable($setup->getTable('sy_news_item'))
			->addColumn(
				'id',
				\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
				null,
				[
					'identity' => true, 
					'unsigned' => true, 
					'nullable' => false, 
					'primary' => true
				],
				'Id'
			)->addColumn(
				'image',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				255,
				[
					'nullable' => true
				],
				'Image'
			)->addColumn(
				'title',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				255,
				[
					'nullable' => true
				],
				'Title'
			)->addColumn(
				'description',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				null,
				[
					'nullable' => true
				],
				'Description'
			)->addColumn(
				'text',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				null,
				[
					'nullable' => true
				],
				'Text'
			)->addColumn(
				'url_key',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				255,
				[
					'nullable' => true
				],
				'Url Key'
			)->addColumn(
				'active',
				\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
				1,
				[
					'nullable' => false,
					'default' => '1'
				],
				'Active'
			)->addColumn(
				'created_at',
				\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
				null,
				[
					'nullable' => false,
					'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
				],
				'Created At'
			)->addColumn(
				'updated_at',
				\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
				null,
				[
					'nullable' => false,
					'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE
				],
				'Updated At'
			)->setComment(
				'News Table'
			);
		$setup->getConnection()->createTable($table);

		$setup->endSetup();
	}
}