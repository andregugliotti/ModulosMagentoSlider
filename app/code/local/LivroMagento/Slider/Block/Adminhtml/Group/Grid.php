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
class LivroMagento_Slider_Block_Adminhtml_Group_Grid
    extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('sliderGroupGrid');
        $this->setDefaultSort('slider_group_id');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('livromagento_slider/group')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('slider_group_id', array(
            'header'    => Mage::helper('livromagento_slider')->__('ID'),
            'align'     => 'left',
            'index'     => 'slider_group_id',
            'type'      => 'number'
        ));

        $this->addColumn('code', array(
            'header'    => Mage::helper('livromagento_slider')->__('Code'),
            'align'     => 'left',
            'index'     => 'code',
        ));

        $this->addColumn('title', array(
            'header'    => Mage::helper('livromagento_slider')->__('Title'),
            'align'     => 'left',
            'index'     => 'title',
        ));

        $this->addColumn('images', array(
            'header'    => Mage::helper('livromagento_slider')->__('Images'),
            'align'     => 'center',
            'index'     => 'images',
            'renderer'  => 'LivroMagento_Slider_Block_Adminhtml_Group_Grid_Renderer_Group_Image'
        ));

        $this->addColumn('is_active', array(
            'header'    => Mage::helper('livromagento_slider')->__('Status'),
            'index'     => 'is_active',
            'type'      => 'options',
            'options'   => array(
                LivroMagento_Slider_Model_Group::DISABLED => Mage::helper('livromagento_slider')->__('Disabled'),
                LivroMagento_Slider_Model_Group::ENABLED => Mage::helper('livromagento_slider')->__('Enabled')
            ),
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('slider_group_id' => $row->getId()));
    }
}
