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
class LivroMagento_Slider_Block_Adminhtml_Group_Grid_Renderer_Group_Image
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        return $this->_getValue($row);
    }

    protected function _getValue(Varien_Object $row)
    {
        /** @var LivroMagento_Slider_Model_Group $row */
        $images = Mage::getModel('livromagento_slider/image')->getImagesByGroup($row, false);

        if (!isset($images)) {
            return 'Images is empty';
        }

        $result = '<ul>';
        foreach ($images as $image) {
            $result .= '<li style="display: inline-block">';
            $block = Mage::app()->getLayout()->createBlock('livromagento_slider/view');
            if (!getimagesize($block->getImageSrc($image))) {
                $result .= $image->getFilename();
                continue;
            }
            $result .= Mage::helper('livromagento_slider')->getImage($image, 30);
            $result .= "<br /><label>{$row->getFilename()}</label>";
            $result .= '</li>';
        }
        $result .= '</ul>';

        return $result;
    }
}
