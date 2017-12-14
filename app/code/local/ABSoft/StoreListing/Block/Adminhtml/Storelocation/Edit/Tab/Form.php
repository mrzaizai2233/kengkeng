<?php

class ABSoft_StoreListing_Block_Adminhtml_Storelocation_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {

        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset("storelisting_form", array("legend" => Mage::helper("storelisting")->__("Item information")));
        $stores = array();
        if (!empty(Mage::app()->getRequest()->getParam("id"))) {
            $current_id = Mage::app()->getRequest()->getParam("id");
            $store_locations = Mage::getModel('storelisting/storelocation')->getCollection()->addFieldToFilter('store_location_id', $current_id);
            $store_locations->getSelect()->join(['core_store' => $store_locations->getTable('core/store')],
                'main_table.store_id = core_store.store_id',
                ["core_store.name as core_store_name", "main_table.name as name_of_main_table"]
            );
            $data = $store_locations->getFirstItem();
            $stores[$data->getStoreId()] = $data->getCoreStoreName();;


        } else {
            $stores = ABSoft_StoreListing_Block_Adminhtml_Storelocation_Grid::getStores();
        }

        $fieldset->addField('store_id', 'select', array(
            'label' => Mage::helper('storelisting')->__('Store'),
            'values' => $stores,
            'name' => 'store_id',
            'onclick' => "",
            'onchange' => "",
            'disabled' => false,
            'readonly' => false,
            'tabindex' => 1
        ));
        $fieldset->addField("address", "text", array(
            "label" => Mage::helper("storelisting")->__("Address"),
            "name" => "address",
        ));
        $fieldset->addField("latitude", "text", array(
            "label" => Mage::helper("storelisting")->__("Latitude"),
            "name" => "latitude",
            'readonly' => true,
        ));

        $fieldset->addField("longitude", "text", array(
            "label" => Mage::helper("storelisting")->__("Longitude"),
            "name" => "longitude",
            'readonly' => true,

        ));


        $fieldset->addField("postcode", "text", array(
            "label" => Mage::helper("storelisting")->__("Postal code"),
            "name" => "postcode",
        ));

        $fieldset->addField("city", "text", array(
            "label" => Mage::helper("storelisting")->__("City"),
            "name" => "city",

        ));
        $fieldset->addField("time_open", "text", array(
            "label" => Mage::helper("storelisting")->__("Time Open"),
            "name" => "time_open"

        ));
//        $fieldset->addField('img', 'file', array(
//            'label'     => Mage::helper('storelisting')->__('File label'),
//            'required'  => false,
//            'name'      => 'img',
//        ));
        $fieldset->addField('img', 'image', array(
            'label'     => Mage::helper('storelisting')->__('Image'),
            'required'  => false,
            'name'      => 'img',
        ));

        if (Mage::getSingleton("adminhtml/session")->getStorelocationData()) {
            $form->setValues(Mage::getSingleton("adminhtml/session")->getStorelocationData());
            Mage::getSingleton("adminhtml/session")->setStorelocationData(null);
        } elseif (Mage::registry("storelocation_data")) {
            $form->setValues(Mage::registry("storelocation_data")->getData());
        }
        return parent::_prepareForm();
    }
}