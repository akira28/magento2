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
 * @category    Mage
 * @package     Mage_GoogleCheckout
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


class Mage_GoogleCheckout_Model_Source_Shipping_Virtual_Method
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'email', 'label' => Mage::helper('Mage_GoogleCheckout_Helper_Data')->__('Email delivery')),
            // array('value'=>'key_url', 'label'=> Mage::helper('Mage_GoogleCheckout_Helper_Data')->__('Key/URL delivery')),
            // array('value'=>'description_based', 'label'=> Mage::helper('Mage_GoogleCheckout_Helper_Data')->__('Description-based delivery'))
        );
    }
}
