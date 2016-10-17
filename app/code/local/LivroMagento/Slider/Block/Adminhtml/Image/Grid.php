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
class LivroMagento_Slider_Block_Adminhtml_Image_Grid
    extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('sliderImageGrid');
        $this->setDefaultSort('slider_image_id');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('livromagento_slider/image')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('slider_image_id', array(
            'header'    => Mage::helper('livromagento_slider')->__('ID'),
            'align'     => 'left',
            'index'     => 'slider_image_id',
            'type'      => 'number'
        ));

        $this->addColumn('title', array(
            'header'    => Mage::helper('livromagento_slider')->__('Title'),
            'align'     => 'left',
            'index'     => 'title',
        ));

        $this->addColumn('link', array(
            'header'    => Mage::helper('livromagento_slider')->__('Link'),
            'align'     => 'left',
            'index'     => 'link'
        ));

        $this->addColumn('filename', array(
            'header'    => Mage::helper('livromagento_slider')->__('File Image'),
            'align'     => 'center',
            'index'     => 'filename',
            'renderer'  => 'LivroMagento_Slider_Block_Adminhtml_Image_Grid_Renderer_Image'
        ));

        $this->addColumn('is_active', array(
            'header'    => Mage::helper('livromagento_slider')->__('Status'),
            'index'     => 'is_active',
            'type'      => 'options',
            'options'   => array(
                LivroMagento_Slider_Model_Image::DISABLED => Mage::helper('livromagento_slider')->__('Disabled'),
                LivroMagento_Slider_Model_Image::ENABLED => Mage::helper('livromagento_slider')->__('Enabled')
            ),
        ));

        $this->addColumn('group_ids', array(
            'header'    => Mage::helper('livromagento_slider')->__('Groups'),
            'align'     => 'center',
            'index'     => 'group_ids',
            'renderer'  => 'LivroMagento_Slider_Block_Adminhtml_Image_Grid_Renderer_Groups',
            'filter_condition_callback' => array($this, '_prepareFilterGroup'),
            'type'      => 'options',
            'options'      => Mage::getSingleton('livromagento_slider/system_config_groups')->toOptionArray()
        ));

        $this->addColumn('position', array(
            'header'    => Mage::helper('livromagento_slider')->__('Position'),
            'align'     => 'center',
            'type'      => 'number',
            'index'     => 'position'
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareFilterGroup(LivroMagento_Slider_Model_Resource_Image_Collection $collection, $column)
    {
        $filterValue = $column->getFilter()->getValue();
        $groupFilter = Mage::getModel('livromagento_slider/group')->getCollection();
        $groupFilter->addFieldToFilter('code', array('eq'=>$filterValue));

        $groupIDs = array();
        foreach ($groupFilter as $filter) {
            $groupIDs[] = $filter->getCode();
        }

        foreach ($groupIDs as $id) {
            $collection->addFieldToFilter('group_ids', array('like' => '%'.$id.'%'));
        }

        return $this;
    }

    public function getRowUrl(Varien_Object $row)
    {
        return $this->getUrl('*/*/edit', array('slider_image_id' => $row->getSliderImageId()));
    }
}
