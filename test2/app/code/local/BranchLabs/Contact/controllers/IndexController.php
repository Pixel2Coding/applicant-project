<?php
class BranchLabs_Contact_IndexController extends Mage_Core_Controller_Front_Action
{
    public function IndexAction()
    {

        $this->loadLayout();
        $this->getLayout()->getBlock("head")->setTitle($this->__("Contact's information"));
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

        $this->renderLayout();

    }
}