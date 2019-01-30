<?php
class BranchLabs_Contact_ViewController extends Mage_Core_Controller_Front_Action
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
        $this->loadLayout();
        $this->getLayout()->getBlock("head")->setTitle($this->__("View Contact's information"));
        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
        $breadcrumbs->addCrumb("home", array(
            "label" => $this->__("Home Page"),
            "title" => $this->__("Home Page"),
            "link" => Mage::getBaseUrl()
        ));

        $breadcrumbs->addCrumb("contact's information", array(
            "label" => $this->__("Contact's information"),
            "title" => $this->__("Contact's information")
        ));

        $this->getLayout()->getBlock('contact_view')->setContact($cotnact);

        $this->renderLayout();

    }
}