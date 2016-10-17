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
class LivroMagento_Slider_Adminhtml_ImageController
    extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('slider/image')
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
            ->_title($this->__('Manage Image'));
        
        $id = $this->getRequest()->getParam('slider_image_id');
        $model = Mage::getModel('livromagento_slider/image');
        
        if ($id) {
            $model->load($id);
            if (! $model->getSliderImageId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('livromagento_slider')->__('This slider image no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Slider Image'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (! empty($data)) {
            $model->setData($data);
        }

        Mage::register('slider_image', $model);

        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('livromagento_slider')->__('Edit Slider Image') : Mage::helper('livromagento_slider')->__('New Slider Image'), $id ? Mage::helper('livromagento_slider')->__('Edit Slider Image') : Mage::helper('livromagento_slider')->__('New Slider Image'))
            ->renderLayout();
    }

    /**
     * Save action
     */
    public function saveAction()
    {
        $data = $this->getRequest()->getPost();
        if (isset($data['group_ids'])) {
            $groupIds = implode(',', $data['group_ids']);
            $data['group_ids'] = $groupIds;
        }

        if (!$data) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('livromagento_slider')->__('Data is empty'));
            $this->_redirect('*/*/');
            return;
        }

        $id = (int) $this->getRequest()->getParam('slider_image_id');
        $model = Mage::getModel('livromagento_slider/image');

        if ($id) {
            $model->load($id);
            if (!$model->getSliderImageId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('livromagento_slider')->__('This slider image no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        unset ($data['filename']);

        if (isset($_FILES)) {
            if (isset($data['filename']['delete'])) {
                $data['filename'] = null;
            }
            if (isset($_FILES['filename']['tmp_name']) && $_FILES['filename']['tmp_name'] != '') {
                $uploader = new Mage_Core_Model_File_Uploader($_FILES['filename']);
                $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
                $uploader->setAllowRenameFiles(true);
                $path = Mage::getBaseDir('media') . DS . LivroMagento_Slider_Block_View::PATH;
                $result = $uploader->save($path);
                $data['filename'] = $result['file'];
            }

            if (is_array($data['filename'])) {
                unset($data['filename']);
            }
        }

        foreach ($data as $key => $value) {
            $model->setData($key, $value);
        }

        try {
            $model->save();
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('livromagento_slider')->__('The slider image has been saved.'));
            Mage::getSingleton('adminhtml/session')->setFormData(false);
            $this->_redirect('*/*/');
            return;
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::getSingleton('adminhtml/session')->setFormData($data);
            $this->_redirect('*/*/edit', array('slider_image_id' => $this->getRequest()->getParam('slider_image_id')));
            return;
        }
        $this->_redirect('*/*/');
    }

    /**
     * Delete action
     */
    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('slider_image_id');
        if (!$id) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('livromagento_slider')->__('Data is empty'));
            $this->_redirect('*/*/');
            return;
        }

        $model = Mage::getModel('livromagento_slider/image')->load($id);

        try {
            $model->delete();
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('livromagento_slider')->__('The slider image has been deleted.'));
            $this->_redirect('*/*/');
            return;
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            $this->_redirect('*/*/edit', array('slider_image_id' => $id));
            return;
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('livromagento_slider')->__('Unable to find a slider image to delete.'));
        $this->_redirect('*/*/');
    }

    protected function _isAllowed()
    {
        switch ($this->getRequest()->getActionName()) {
            case 'new':
            case 'save':
                return Mage::getSingleton('admin/session')->isAllowed('cms/slider/save');
                break;
            case 'delete':
                return Mage::getSingleton('admin/session')->isAllowed('cms/page/delete');
                break;
            default:
                return Mage::getSingleton('admin/session')->isAllowed('cms/page');
                break;
        }
    }
}
