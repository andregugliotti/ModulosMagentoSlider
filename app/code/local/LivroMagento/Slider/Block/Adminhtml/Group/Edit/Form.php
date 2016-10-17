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
class LivroMagento_Slider_Block_Adminhtml_Group_Edit_Form
    extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('slider_group');
        $form = new Varien_Data_Form(
            array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save', array('slider_group_id' => $this->getRequest()->getParam('slider_group_id'))),
                'method' => 'post',
                'enctype' => 'multipart/form-data'
            )
        );
        $form->setHtmlIdPrefix('slider_group_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('livromagento_slider')->__('Slider Group Information')));

        $fieldset->addField('title', 'text', array(
            'name'      => 'title',
            'label'     => Mage::helper('livromagento_slider')->__('Slider Group Title'),
            'title'     => Mage::helper('livromagento_slider')->__('Slider Group Title'),
            'required'  => true
        ));

        $fieldset->addField('code', 'text', array(
            'name'      => 'code',
            'label'     => Mage::helper('livromagento_slider')->__('Slider Group Code'),
            'title'     => Mage::helper('livromagento_slider')->__('Slider Group Code'),
            'required'  => true
        ));

        $fieldset->addField('is_active', 'select', array(
            'label'     => Mage::helper('livromagento_slider')->__('Status'),
            'title'     => Mage::helper('livromagento_slider')->__('Page Status'),
            'name'      => 'is_active',
            'required'  => true,
            'options'   => array(
                LivroMagento_Slider_Model_Group::ENABLED => Mage::helper('livromagento_slider')->__('Enabled'),
                LivroMagento_Slider_Model_Group::DISABLED => Mage::helper('livromagento_slider')->__('Disabled'),
            ),
        ));

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
