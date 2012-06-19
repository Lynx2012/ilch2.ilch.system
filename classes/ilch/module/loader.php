<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Module loader class
 *
 * @package    Ilch
 * @category   Core/Module
 * @author     Ilch Team
 * @copyright  (c) 2012 Ilch Team
 * @license    http://www.ilch-pluto.net/license
 */
class Ilch_Module_Loader extends Content_Loader {
	
	const LOADER_NAME = 'module';
	
    const MODULES_DEFAULTS = 'defaults';
    const MODULES_DATABASE = 'database';
    
	/**
	 * @var array Paths to search modules
	 */
	public static $paths = array();
	
    /**
     * @var array Default modules to load on startup
     */
    protected static $_defaults = array('dbconfig', 'event', 'jelly', 'database');
    
    /**
     * Set default modules
     */
    public static function set_defaults(array $value)
    {
        Module_Loader::$_defaults = $value;
        return Module_Loader::get_defaults();
    }
    
    /**
     * Get default modules
     */
    public static function get_defaults()
    {
        return Module_Loader::$_defaults;
    }
	
    /**
     * Load default, database or custom modules
     * @param array $modules array with modules group or array with modules
     * @param bool $ignore_missing ignore missing modules or throw an exeption?
     * @param bool $overload overload the current loaded modules completly
     * @param bool $initialize auto initialize the loaded modules
     */
    public static function load($modules, $ignore_missing = TRUE, $overload = FALSE, $initialize = TRUE)
    {
        if (isset($modules[0]))
        {
            // Get default modules
            if ($modules[0] == Module_Loader::MODULES_DEFAULTS)
            {
                $modules = Module_Loader::_get_from_defaults();
            }
            // Get active modules from database
            elseif ($modules[0] == Module_Loader::MODULES_DATABASE)
            {
                $modules = Module_Loader::_get_from_database();
            }
        }
        
        return Module_Loader::_load($modules, $ignore_missing, $overload, $initialize);
    }
    
    /**
     * Get all default active environment modules
     * @return array
     */
    protected static function _get_from_defaults()
    {
        // Create empty module array
        $modules = array();
        
        // Collect modules
        foreach(Module_Loader::$_defaults AS $name)
        {
	        $modules[Module_Loader::name(Module_Loader::LOADER_NAME, $name)] = Module_Loader::path($name);
        }
        
        // Load modules
        return $modules;
    }

    /**
     * Get all active modules from database
     * @return array
     */
    protected static function _get_from_database()
    {
        // Create empty module array
        $modules = array();
        
        $result = Jelly::query('module')->active()->order()->execute();
        
        foreach($result as $row)
        {
            if ($row->loaded())
            {
                $modules[Module_Loader::name($row->source, $row->name)] = Module_Loader::path('module', $row->source, $row->name);
            }
        }
        
        // Load modules
        return $modules;
    }
}