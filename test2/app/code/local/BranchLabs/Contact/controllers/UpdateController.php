<?php
class BranchLabs_Contact_UpdateController extends Mage_Core_Controller_Front_Action
{
    public function IndexAction()
    {
        if (!$this->getRequest()->getParam('id')) {
            Mage::getSingleton('customer/session')->addError(Mage::helper('contacts')->__('Something went wrong'));
            $this->_redirect('contact');
        }


        $cotnact = Mage::getModel('contact/contacts')->load($this->getRequest()->getParam('id'));
        if (!$cotnact->getId()) {
            Mage::getSingleton('customer/session')->addError(Mage::helper('contacts')->__('Id doesnt exists'));
            $this->_redirect('contact');
        }

        $data = $this->getRequest()->getParams();
        $data['email'] = $data['mail'];
        
        $cotnact
            ->setId($this->getRequest()->getParam('id'))
            ->setData($data)
            ->save();

        Mage::getSingleton('customer/session')->addSuccess(Mage::helper('contacts')->__('Successfully updated Contact'));
        $this->_redirect('contact');
    }
}