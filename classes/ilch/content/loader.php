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
class Ilch_Content_Loader {
	
    /**
     * @var array Loaded modules collector
     */
    protected static $_loaded = array();
    
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
     * Load modules
     * @param array $modules array with modules
     * @param bool $ignore_missing ignore missing modules or throw an exeption?
     * @param bool $overload overload the current loaded modules completly
     * @param bool $initialize auto initialize the loaded modules
     */
    protected static function _load($modules, $ignore_missing = TRUE, $overload = FALSE, $initialize = TRUE)
    {
        // Be sure to only profile if it's enabled
        if (Kohana::$profiling === TRUE)
        {
            // Start a new benchmark
            $benchmark = Profiler::start('Content loader', __FUNCTION__);
        }
        
        // Merge loaded modules and new modules
        if ( ! $overload) $modules = array_merge($modules, Content_Loader::get_loaded());
        
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
            else
            {
                unset($modules[$name]);
            }
        }

        // Finish the include paths by adding ILCH_SYSPATH and SYSPATH
        $paths[] = ILCH_SYSTEM;
        $paths[] = KOHANA_SYSTEM;

        // Set the new include paths
        Ilch::set_paths($paths);

        // Set the current module list
        Content_Loader::set_loaded($modules);

        // Initialize modules
        if ($initialize) Content_Loader::initialize_loaded();

        // Run event
        Event::run('Ilch_Content_Loader::_load::after');

        if (isset($benchmark))
        {
            // Stop the benchmark
            Profiler::stop($benchmark);
        }

        return Module_Loader::get_loaded();
    }

    /**
     * Initialize loaded modules
     */
    public static function initialize_loaded()
    {
        foreach (Content_Loader::get_loaded() AS $path)
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
     * Get path to module, theme or other content
     * @param string like "module" or "theme"
     * @param string like "ilch", "kohana" or "application"
     * @param string
     * @return string
     */
    public static function path($type, $source, $name)
    {
        return constant(strtoupper(sprintf('%s_%s', $source, $type))).DS.$name;
    }
}
