<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition License
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magentocommerce.com/license/enterprise-edition
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
 * @package     Mage_Paypal
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */

/**
 * Fieldset renderer for PayPal solution
 *
 * @category    Mage
 * @package     Mage_Paypal
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Paypal_Block_Adminhtml_System_Config_Fieldset_Payment
        extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
    /**
     * Add custom css class
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getFrontendClass($element)
    {
        return parent::_getFrontendClass($element) . ' with-button '
            . ($this->_isPaymentEnabled($element) ? ' enabled' : '');
    }

    /**
     * Check whether current payment method is enabled
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return bool
     */
    protected function _isPaymentEnabled($element)
    {
        $groupConfig = $this->getGroup($element)->asArray();
        $activityPath = isset($groupConfig['activity_path']) ? $groupConfig['activity_path'] : '';

        if (empty($activityPath)) {
            return false;
        }

        $isPaymentEnabled = (string)Mage::getSingleton('adminhtml/config_data')->getConfigDataValue($activityPath);

        return (bool)$isPaymentEnabled;
    }

    /**
     * Return header title part of html for payment solution
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getHeaderTitleHtml($element)
    {
        $html = '<div class="config-heading" ><div class="heading"><strong>' . $element->getLegend();

        $groupConfig = $this->getGroup($element)->asArray();
        if (!empty($groupConfig['learn_more_link'])) {
            $html .= '<a class="link-more" href="' . $groupConfig['learn_more_link'] . '" target="_blank">'
                . $this->__('Learn More') . '</a>';
        }
        if (!empty($groupConfig['demo_link'])) {
            $html .= '<a class="link-demo" href="' . $groupConfig['demo_link'] . '" target="_blank">'
                . $this->__('View Demo') . '</a>';
        }
        $html .= '</strong>';

        if ($element->getComment()) {
            $html .= '<span class="heading-intro">' . $element->getComment() . '</span>';
        }
        $html .= '</div>';

        $html .= '<div class="button-container"><button type="button"'
            . ($this->_isPaymentEnabled($element) ? '' : ' disabled="disabled"') . ' class="button'
            . (empty($groupConfig['paypal_ec_separate']) ? '' : ' paypal-ec-separate')
            . ($this->_isPaymentEnabled($element) ? '' : ' disabled') . '" id="' . $element->getHtmlId()
            . '-head" onclick="paypalToggleSolution.call(this, \'' . $element->getHtmlId() . '\', \''
            . $this->getUrl('*/*/state') . '\'); return false;"><span class="state-closed">'
            . $this->__('Configure') . '</span><span class="state-opened">'
            . $this->__('Close') . '</span></button></div></div>';

        return $html;
    }

    /**
     * Return header comment part of html for payment solution
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getHeaderCommentHtml($element)
    {
        return '';
    }

    /**
     * Get collapsed state on-load
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return bool
     */
    protected function _getCollapseState($element)
    {
        return false;
    }
}
