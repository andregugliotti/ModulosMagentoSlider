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
 * @package    LivroMagento_
 * @author     Leandro Rosa <dev.leandrorosa@gmail.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */
class LivroMagento_Slider_Helper_Data
    extends Mage_Core_Helper_Abstract
{
    /**
     * @param LivroMagento_Slider_Model_Group $group
     * @return LivroMagento_Slider_Model_Image
     */
    public function getGroupImages(LivroMagento_Slider_Model_Group $group)
    {
        if (!$group->getImages()) {
            return;
        }
        $imagesIDs = explode(',', $group->getImages());
        if (empty($imagesIDs) || !is_array($imagesIDs)) {
            return;
        }
        $images = Mage::getModel('livromagento_slider/image');
        $images->getCollection()
            ->addFieldToSelect('*')
            ->addFieldToFilter('slider_image_id', array('in' => $imagesIDs));
        return  $images;
    }

    public function getImage(LivroMagento_Slider_Model_Image $image, $width = null, $height = null)
    {
        $block = Mage::app()->getLayout()->createBlock('livromagento_slider/view');
        if (!$image->getFilename() || !getimagesize($block->getImageSrc($image))) {
            return Mage::helper('livromagento_slider')->__('Image not found!');
        }
        $url = $block->getImageSrc($image);

        $size = '';

        if ($width) {
            $size .= "width='{$width}px' ";
        }

        if ($height) {
            $size .= "height='{$height}px' ";
        }
        $result = "<img src={$url} {$size} alt='{$image->getTitle()}' title='{$image->getTitle()}'/>";
        return $result;
    }
}
