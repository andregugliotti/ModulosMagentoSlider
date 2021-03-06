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
class LivroMagento_Slider_Block_Adminhtml_Group_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'slider_group_id';
        $this->_blockGroup = 'livromagento_slider';
        $this->_controller = 'adminhtml_group';

        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('livromagento_slider')->__('Save Slider Group'));
        $this->_updateButton('delete', 'label', Mage::helper('livromagento_slider')->__('Delete Slider Group'));
    }

    /**
     * @return string
     */
    public function getHeaderText()
    {
        if (!Mage::registry('slider_group')->getSliderGroupId()) {
            return Mage::helper('livromagento_slider')->__('New Block');
        }
        return Mage::helper('livromagento_slider')->__("Edit Slider Group '%s'", $this->escapeHtml(Mage::registry('slider_group')->getTitle()));
    }
}
