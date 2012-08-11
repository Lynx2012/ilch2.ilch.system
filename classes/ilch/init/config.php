<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Ilch config class initialize all config readers, groups and fields
 */
class Ilch_Init_Config {
    
    public static function init()
    {
        self::readers();
        self::groups();
        self::fields();
    }
    
    protected static function readers()
    {
		// Attach a file reader to config
		Ilch::$config->attach(new Config_File);
		
		// Attach a database reader to config
		Ilch::$config->attach(new Config_Database);
    }
    
    protected static function groups()
    {
        // General settings
        Config_Register::set_group('system', 'General settings');
        
        // Theme settings
        Config_Register::set_group('system_theme', 'Theme settings');
        
    }
    
    protected static function fields()
    {
        // General settings
        Config_Register::add_field('system', 'index_page', 'Home page', array(
            'Bootstrap_Form_Input', 'init'
        ), array(
            'name' => NULL,
        ), array());
        
        // Theme settings
        Config_Register::add_field('system_theme', 'frontend', 'Frontend theme', array(
            'Config_Field_Theme', 'installed'
        ), array(
            'name' => NULL,
            'section' => 'frontend'
        ), array());
        
        Config_Register::add_field('system_theme', 'backend', 'Backend theme', array(
            'Config_Field_Theme', 'installed'
        ), array(
            'name' => NULL,
            'section' => 'backend'
        ), array());
    }
    
}
