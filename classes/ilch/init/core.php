<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Initialize Ilch
 */
class Ilch_Init_Core {
    
    protected static $_initialized = FALSE;
    
    public static function init()
    {
        // Initialize only one time
        if (Ilch_Init::$_initialized)
            return FALSE;
        
        // Load default modules
		Content_Module_Loader::load((array) Content_Module_Loader::MODULES_DEFAULTS, FALSE, TRUE, FALSE);
        
        // Initialize Config
        Ilch_Init_Config::init();
		
		// Load custom modules
		Content_Module_Loader::load((array) Content_Module_Loader::MODULES_DATABASE);
		
        // Initialize ilch routes
        Ilch_Init_Routing::init();
        
        // Initialize ilch user system
        Ilch_Init_User::init();
        
        // Initialize backend
        Event::add('Classes_Ilch_Controller_Backend_Template::before::before', array('Ilch_Init_Backend', 'init'));
        
        // Success
        return Ilch_Init::$_initialized = TRUE;
    }

}
