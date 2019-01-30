<?php
class BranchLabs_Contact_DeleteController extends Mage_Core_Controller_Front_Action
{
    public function IndexAction()
    {
        if (!$this->getRequest()->getParam('id')) {
            Mage::getSingleton('customer/session')->addError(Mage::helper('contacts')->__('Something went wrong'));
            $this->_redirect('*/*/');
        }


        $cotnact = Mage::getModel('contact/contacts')->load($this->getRequest()->getParam('id'));
        if (!$cotnact->getId()) {
            Mage::getSingleton('customer/session')->addError(Mage::helper('contacts')->__('Id doesnt exists'));
            $this->_redirect('*/*/');
        }

        $cotnact->delete();

        Mage::getSingleton('customer/session')->addSuccess(Mage::helper('contacts')->__('Successfully Deleted Contact'));
        $this->_redirect('contact');
    }
}