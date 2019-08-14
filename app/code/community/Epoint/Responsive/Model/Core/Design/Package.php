<?php

class Epoint_Responsive_Model_Core_Design_Package extends Mage_Core_Model_Design_Package
{

    /**
     * Retrieve package name
     *
     * @return string
     */
    public function getPackageName()
    {
        if (null === $this->_name) {
            $this->setPackageName();
        }
        $customDesign = $this->getCustomDesign('package');

        if ($customDesign) {
            $this->_name = $customDesign;
        }

        return $this->_name;
    }

    public function getTheme($type)
    {
        if (empty($this->_theme[$type])) {
            $this->_theme[$type] = Mage::getStoreConfig('design/theme/' . $type, $this->getStore());
            if ($type !== 'default' && empty($this->_theme[$type])) {
                $this->_theme[$type] = $this->getTheme('default');
                if (empty($this->_theme[$type])) {
                    $this->_theme[$type] = self::DEFAULT_THEME;
                }

                // "locale", "layout", "template"
            }
        }

        // + "default", "skin"

        // set exception value for theme, if defined in config
        $customThemeType = $this->_checkUserAgentAgainstRegexps("design/theme/{$type}_ua_regexp");
        $customDesign = $this->getCustomDesign('theme');

        if ($customThemeType) {
            $this->_theme[$type] = $customThemeType;
        }

        if ($customDesign) {
            $this->_theme[$type] = $customDesign;
        }

        return $this->_theme[$type];
    }

    /**
     * returns package name or theme name if custom design config set, and false if custom design is not set
     *
     * @param string $type theme|package
     *
     * @return bool|mixed
     */
    public function getCustomDesign($type = '')
    {
        $customDesign = false;
        if (Mage::helper('eresponsive')->isTablet() && Mage::getStoreConfig('design/theme/tablet')) {
            $customDesign = Mage::getStoreConfig('design/theme/tablet');
        } elseif (Mage::helper('eresponsive')->isMobile() && Mage::getStoreConfig('design/theme/mobile')) {
            $customDesign = Mage::getStoreConfig('design/theme/mobile');
        }

        if ($customDesign) {
            if ($type == 'package') {
                $customDesign = reset(explode('/', $customDesign));
            } elseif ($type == 'theme') {
                $customDesign = end(explode('/', $customDesign));
            }
        }

        return $customDesign;
    }
}
