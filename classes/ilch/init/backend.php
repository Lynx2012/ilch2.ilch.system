<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Initialize only on backend template
 */
class Ilch_Init_Backend {
    
    protected static $_initialized = FALSE;

    public static function init()
    {
        // Initialize only one time
        if (self::$_initialized)
            return FALSE;
        
        self::navigation();
        
        // Success
        return self::$_initialized = TRUE;
    }
    
    protected static function navigation()
    {
        //var_dump(Widget_Backend_Navigation::group('main'));
        //print_r(Template_Backend_Navigation::group('dashboard'));
    }
    
}
