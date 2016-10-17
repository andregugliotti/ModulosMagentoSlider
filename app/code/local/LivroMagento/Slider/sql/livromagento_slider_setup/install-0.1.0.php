<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   LivroMagento
 * @package    LivroMagento_Slider
 * @author     Leandro Rosa <dev.leandrorosa@gmail.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * Create table 'livromagento_slider/image'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('livromagento_slider/image'))
    ->addColumn('slider_image_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Slider Image ID')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Slider Image Title')
    ->addColumn('link', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
    ), 'Slider Image Link')
    ->addColumn('target', Varien_Db_Ddl_Table::TYPE_VARCHAR, 20, array(
        'nullable'  => true,
    ), 'Slider Image Target')
    ->addColumn('filename', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
    ), 'Slider Image Filename')
    ->addColumn('group_ids', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
        'nullable'  => true,
    ), 'Slider Image Group IDs')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => '1',
    ), 'Is Slider Image Active')
    ->addColumn('position', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable'  => true,
    ), 'Slider Image Position')
    ->setComment('Slider Image Table');
$installer->getConnection()->createTable($table);


/**
 * Create table 'livromagento_slider/group'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('livromagento_slider/group'))
    ->addColumn('slider_group_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Slider Group ID')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 60, array(
        'nullable'  => false,
    ), 'Slider Group Title')
    ->addColumn('code', Varien_Db_Ddl_Table::TYPE_VARCHAR, 60, array(
        'nullable'  => false,
    ), 'Slider Group Code')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => '1',
    ), 'Is Slider Group Active')
    ->setComment('Slider Group Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();
