<?php defined('SYSPATH') or die('No direct script access.');

class Ilch_Config_Field_Theme extends Bootstrap_Form_Select {
    
    public static function installed($name, $section = NULL, $value = NULL, $extended = array())
    {
        if (is_array($name))
        {
            extract($name);
        }
        
        if (!is_string($name) AND !is_null($name))
        {
            throw new Kohana_Exception('$name must be a string or null');
        }
        
        if (!is_string($section))
        {
            throw new Kohana_Exception('$section must be a string');
        }
        
        // Set options
        $options = array();
        $themes = Theme_Manager::get_installed($section);
        
        foreach ($themes AS $theme)
        {
            $options[$theme['model']->id] = $theme['model']->name;
        }
        
        return parent::init($name, $options, $value, $extended);
    }
    
}
