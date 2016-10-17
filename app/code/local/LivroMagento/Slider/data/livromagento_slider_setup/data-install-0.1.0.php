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

$images = array(
    array(
        'title' => 'Exemplo 1',
        'link' => 'http://www.magentoconnect.com/',
        'target' => '_blank',
        'filename' => 'image_1.jpg',
        'group_ids' => 'homepage_slider, left_banner',
        'is_active' => LivroMagento_Slider_Model_Image::ENABLED,
        'position' => 1
    ),
    array(
        'title' => 'Exemplo 2',
        'link' => Mage::getUrl('contacts'),
        'target' => '_parent',
        'filename' => 'image_2.png',
        'group_ids' => 'homepage_slider',
        'is_active' => LivroMagento_Slider_Model_Image::ENABLED,
        'position' => 2
    ),
    array(
        'title' => 'Exemplo 3',
        'link' => Mage::getUrl('about-us'),
        'target' => '_parent',
        'filename' => 'image_3.jpg',
        'group_ids' => 'homepage_slider, left_banner',
        'is_active' => LivroMagento_Slider_Model_Image::ENABLED,
        'position', 3
    ),
);

$groups = array(
    array (
        'code' => 'homepage_slider',
        'title' => 'Home Page',
        'is_active' => LivroMagento_Slider_Model_Group::ENABLED
    ),
    array (
        'code' => 'left_banner',
        'title' => 'Banners left',
        'is_active' => LivroMagento_Slider_Model_Group::ENABLED
    )
);

/**
 * Insert Image Data
 */
foreach ($images as $data) {
    Mage::getModel('livromagento_slider/image')->setData($data)->save();
}

/**
 * Insert Group Data
 */
foreach ($groups as $data) {
    Mage::getModel('livromagento_slider/group')->setData($data)->save();
}
