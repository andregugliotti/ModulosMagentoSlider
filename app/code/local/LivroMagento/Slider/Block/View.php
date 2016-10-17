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
class LivroMagento_Slider_Block_View
    extends Mage_Core_Block_Template
{
    const PATH = 'livromagento/slider';

    protected $_group;

    /**
     * @param $code
     */
    public function setGroup($code)
    {
        $this->_group = Mage::getModel('livromagento_slider/group')->getCurrentGroup($code);
    }

    /**
     * @return LivroMagento_Slider_Model_Group
     */
    public function  getGroup()
    {
        return $this->_group;
    }

    /**
     * @return LivroMagento_Slider_Model_Image
     */
    public function getImages()
    {
        $images = Mage::getModel('livromagento_slider/image');
        if (!$images->getImagesByGroup($this->getGroup())) {
            return;
        }
        return $images->getImagesByGroup($this->getGroup());
    }

    /**
     * @param LivroMagento_Slider_Model_Image $image
     * @return string
     */
    public function getImageSrc(LivroMagento_Slider_Model_Image $image)
    {
        $src = Mage::getBaseUrl('media') . self::PATH . DS . $image->getFilename();
        return $src;
    }

    public function isEnabled()
    {
        if ($this->getImages() && $this->getGroup()) {
            return true;
        }
    }
}
