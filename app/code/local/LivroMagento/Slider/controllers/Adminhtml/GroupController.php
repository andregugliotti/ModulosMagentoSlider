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
class LivroMagento_Slider_Adminhtml_GroupController
    extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('slider/group')
            ->_addBreadcrumb(Mage::helper('livromagento_slider')->__('CMS'), Mage::helper('livromagento_slider')->__('CMS'))
            ->_addBreadcrumb(Mage::helper('livromagento_slider')->__('Slider'), Mage::helper('livromagento_slider')->__('Slider'));
        return $this;
    }

    public function indexAction()
    {
        $this->_title($this->__('CMS'))
            ->_title($this->__('Slider'));

        $this->_initAction();
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }
    
    public function editAction()
    {
        $this
            ->_title($this->__('CMS'))
            ->_title($this->__('Slider'))
            ->_title($this->__('Manage Group'));
        
        $id = $this->getRequest()->getParam('slider_group_id');
        $model = Mage::getModel('livromagento_slider/group');
        
        if ($id) {
            $model->load($id);
            if (! $model->getSliderGroupId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('livromagento_slider')->__('This slider group no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Slider Group'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (! empty($data)) {
            $model->setData($data);
        }

        Mage::register('slider_group', $model);

        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('livromagento_slider')->__('Edit Slider Group') : Mage::helper('livromagento_slider')->__('New Slider Group'), $id ? Mage::helper('livromagento_slider')->__('Edit Slider Group') : Mage::helper('livromagento_slider')->__('New Slider Group'))
            ->renderLayout();
    }

    /**
     * Save action
     */
    public function saveAction()
    {
        $data = $this->getRequest()->getPost();
        if (!$data) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('livromagento_slider')->__('Data is empty'));
            $this->_redirect('*/*/');
            return;
        }

        $id = (int) $this->getRequest()->getParam('slider_group_id');
        $model = Mage::getModel('livromagento_slider/group');

        if($id) {
            $model->load($id);
            if (!$model->getSliderGroupId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('livromagento_slider')->__('This slider group no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }


        foreach ($data as $key => $value) {
            $model->setData($key, $value);
        }

        try {
            $model->save();
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('livromagento_slider')->__('The slider group has been saved.'));
            Mage::getSingleton('adminhtml/session')->setFormData(false);
            $this->_redirect('*/*/');
            return;
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::getSingleton('adminhtml/session')->setFormData($data);
            $this->_redirect('*/*/edit', array('slider_group_id' => $this->getRequest()->getParam('slider_group_id')));
            return;
        }
        $this->_redirect('*/*/');
    }

    /**
     * Delete action
     */
    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('slider_group_id');
        if (!$id) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('livromagento_slider')->__('Data is empty'));
            $this->_redirect('*/*/');
            return;
        }

        $model = Mage::getModel('livromagento_slider/group')->load($id);

        try {
            $model->delete();
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('livromagento_slider')->__('The slider group has been deleted.'));
            $this->_redirect('*/*/');
            return;
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            $this->_redirect('*/*/edit', array('slider_group_id' => $id));
            return;
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('livromagento_slider')->__('Unable to find a slider group to delete.'));
        $this->_redirect('*/*/');
    }
}
