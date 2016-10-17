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
 class LivroMagento_Slider_Block_Adminhtml_Image_Edit_Form
     extends Mage_Adminhtml_Block_Widget_Form
 {
     public function __construct()
     {
         parent::__construct();
         $this->setId('slider_image_form');
         $this->setTitle(Mage::helper('livromagento_slider')->__('Slider Image Information'));
     }

     protected function _prepareForm()
     {
         $model = Mage::registry('slider_image');
         $form = new Varien_Data_Form(
             array(
                 'id' => 'edit_form',
                 'action' => $this->getUrl('*/*/save', array('slider_image_id' => $this->getRequest()->getParam('slider_image_id'))),
                 'method' => 'post',
                 'enctype' => 'multipart/form-data'
             )
         );
         $form->setHtmlIdPrefix('slider_image_');
         $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('livromagento_slider')->__('General Information'), 'class' => 'fieldset-wide'));

         $fieldset->addField('title', 'text', array(
             'name'      => 'title',
             'label'     => Mage::helper('livromagento_slider')->__('Slider Image Title'),
             'title'     => Mage::helper('livromagento_slider')->__('Slider Image Title'),
             'required'  => true,
         ));

         $fieldset->addField('filename', 'image', array(
             'label'     => Mage::helper('livromagento_slider')->__('File Image'),
             'required'  => true,
             'name'      => 'filename',
         ));

         $fieldset->addField('link', 'text', array(
             'name'      => 'link',
             'label'     => Mage::helper('livromagento_slider')->__('Link'),
             'title'     => Mage::helper('livromagento_slider')->__('Link'),
             'required'  => false
         ));

         $fieldset->addField('target', 'select', array(
             'label'     => Mage::helper('livromagento_slider')->__('Target'),
             'title'     => Mage::helper('livromagento_slider')->__('Target'),
             'name'      => 'target',
             'required'  => true,
             'options'   => array(
                 '_blank' => Mage::helper('livromagento_slider')->__('_blank'),
                 '_parent' => Mage::helper('livromagento_slider')->__('_parent'),
                 '_new' => Mage::helper('livromagento_slider')->__('_new'),
             ),
         ));

         $fieldset->addField('group_ids', 'multiselect', array(
             'label'     => Mage::helper('livromagento_slider')->__('Groups'),
             'title'     => Mage::helper('livromagento_slider')->__('Groups'),
             'name'      => 'group_ids',
             'required'  => true,
             'values'   => Mage::getSingleton('livromagento_slider/system_config_groups')->toArray()
         ));

         $fieldset->addField('position', 'text', array(
             'name'      => 'position',
             'label'     => Mage::helper('livromagento_slider')->__('Position'),
             'title'     => Mage::helper('livromagento_slider')->__('Position'),
             'required'  => false
         ));

         $fieldset->addField('is_active', 'select', array(
             'label'     => Mage::helper('livromagento_slider')->__('Status'),
             'title'     => Mage::helper('livromagento_slider')->__('Status'),
             'name'      => 'is_active',
             'required'  => true,
             'options'   => array(
                 LivroMagento_Slider_Model_Image::ENABLED => Mage::helper('livromagento_slider')->__('Enabled'),
                 LivroMagento_Slider_Model_Image::DISABLED => Mage::helper('livromagento_slider')->__('Disabled'),
             ),
         ));

         $form->setValues($model->getData());
         $filename = $form->getElement('filename')->getValue();

         if ($filename) {
             $form->getElement('filename')->setValue(LivroMagento_Slider_Block_View::PATH . '/' . $filename);
         }
         $form->setUseContainer(true);
         $this->setForm($form);
         return parent::_prepareForm();
     }

     protected function _getOptionsGroup()
     {
         $groups = Mage::getModel('livromagento_slider/group')->getCollection();

         $options = array();
         foreach ($groups as $group) {
             $options[] = array(
                 'label' => $group->getTitle(),
                 'value' => $group->getCode()
             );
         }

         return $options;
     }
}
