<?php

class Epoint_Responsive_Model_Adminhtml_System_Config_Source_Design_Package_Theme
{
    protected $_options;

    public function toOptionArray($withoutEmpty = true)
    {
        if (is_null($this->_options)) {
            $design = Mage::getModel('core/design_package')->getThemeList();
            $options = array();
            foreach ($design as $package => $themes) {
                $packageOption = array('label' => $package);
                $themeOptions = array();
                foreach ($themes as $theme) {
                    $themeOptions[] = array(
                        'label' => $theme,
                        'value' => $package . '/' . $theme
                    );
                }
                $packageOption['value'] = $themeOptions;
                $options[] = $packageOption;
            }
            $this->_options = $options;
        }
        $options = $this->_options;
        if (!$withoutEmpty) {
            array_unshift($options, array(
                'value' => '',
                'label' => '',
            ));
        }

        return $options;
    }
}
