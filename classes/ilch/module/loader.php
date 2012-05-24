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
	
    const MODULES_DEFAULTS = 'defaults';
    const MODULES_DATABASE = 'database';
    
    /**
     * @var array Default modules to load on startup
     */
    protected static $_defaults = array(
        'application' => array(),
        'ilch' => array(
            'bootstrap'     => TRUE,
            'database'      => TRUE,
            'event'         => TRUE,
            'fontawesome'   => TRUE,
            'jelly'         => TRUE,
            'jquery'        => TRUE,
        ), 
        'kohana' => array(
            'auth'      => FALSE,
            'cache'     => array('PRODUCTION', 'STAGING'),
            'codebench' => 'DEVELOPMENT',
            'database'  => TRUE,
            'image'     => TRUE,
            'orm'       => FALSE,
            'unittest'  => 'DEVELOPMENT',
            'userguide' => array('TESTING', 'DEVELOPMENT'),
        ),
    );
    
    /**
     * @var array Loaded modules collector
     */
    protected static $_loaded = array();
    
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
     * Set successfully loaded modules
     */
     public static function set_loaded(array $value)
     {
         Module_Loader::$_loaded = $value;
         return Module_Loader::get_loaded();
     }
    
    /**
     * Return all successfully loaded modules
     * @return array
     */
    public static function get_loaded()
    {
        return Module_Loader::$_loaded;
    }
	
    /**
     * Load default, database or custom modules
     * @param mixed $modules string with modules group or array with modules
     * @param bool $ignore_missing ignore missing modules or throw an exeption?
     * @param bool $overload overload the current loaded modules completly
     * @param bool $initialize auto initialize the loaded modules
     */
    public static function load($modules, $ignore_missing = TRUE, $overload = FALSE, $initialize = TRUE)
    {
        if (isset($modules[0]))
        {
            // Get default modules
            if ($modules[0] == self::MODULES_DEFAULTS)
            {
                $modules = Module_Loader::_get_from_defaults();
            }
            // Get active modules from database
            elseif ($modules[0] == self::MODULES_DATABASE)
            {
                $modules = Module_Loader::_get_from_database();
            }
        }
        
        // Merge loaded modules and new modules
        if ( ! $overload) $modules = array_merge(Module_Loader::get_loaded(), $modules);
        
        // Start a new list of include paths, APPPATH first
        $paths = array(APPLICATION_SYSTEM);

        foreach ($modules as $name => $path)
        {
            if (is_dir($path))
            {
                // Add the module to include paths
                $paths[] = $modules[$name] = realpath($path).DS;
            }
            elseif ( ! $ignore_missing)
            {
                // This module is invalid, remove it
                throw new Kohana_Exception('Attempted to load an invalid or missing module \':module\' at \':path\'', array(
                    ':module' => $name,
                    ':path'   => Debug::path($path),
                ));
            }
        }

        // Finish the include paths by adding ILCH_SYSPATH and SYSPATH
        $paths[] = ILCH_SYSTEM;
        $paths[] = KOHANA_SYSTEM;

        // Set the new include paths
        Ilch::set_paths($paths);

        // Set the current module list
        Module_Loader::set_loaded($modules);

        // Initialize modules
        if ($initialize) Module_Loader::initialize_loaded();

        // Run event
        Event::run('Ilch_Module_Loader::load::after');

        return Module_Loader::get_loaded();
    }
    
    /**
     * Initialize loaded modules
     */
    public static function initialize_loaded()
    {
        foreach (Module_Loader::get_loaded() AS $path)
        {
            $init = $path.'init'.EXT;

            if (is_file($init))
            {
                // Include the module initialization file once
                require_once $init;
            }
        }
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
        foreach(Module_Loader::$_defaults AS $key => $val)
        {
            foreach($val AS $name => $condition)
            {
                $check = FALSE;
                
                // Condition is a boolean value
                if (is_bool($condition))
                {
                    $check = $condition;
                }
                // Condition is a string
                elseif (is_string($condition))
                {
                    $check = (constant('Ilch::'.strtoupper($condition)) == Ilch::$environment);
                }
                // Condition is a array
                elseif (is_array($condition))
                {
                    // Two arguments
                    if (count($condition) > 1)
                    {
                        $f_arg = constant('Ilch::'.strtoupper(array_shift($condition)));
                        $s_arg = constant('Ilch::'.strtoupper(array_shift($condition)));
                        
                        $check = (($f_arg <= Ilch::$environment AND $s_arg >= Ilch::$environment) OR ($f_arg >= Ilch::$environment AND $s_arg <= Ilch::$environment));
                    }
                    // One argument
                    elseif (count($condition) == 1)
                    {
                        $check = (constant('Ilch::'.strtoupper(array_shift($condition))) == Ilch::$environment);
                    }
                }
                
                // Save module
                if ($check)
                {
                    $modules[strtolower($key.'_module_'.$name)] = constant(strtoupper($key.'_MODULE')).$name;
                }
            }
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
                $modules[strtolower($row->source.'_module_'.$row->name)] = constant(strtoupper($row->source.'_MODULE')).$row->name;
            }
        }
        
        // Load modules
        return $modules;
    }
    
}