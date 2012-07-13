<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Ilch extension of the Kohana_Core class
 *
 * @package    Ilch
 * @category   Core
 * @author     Ilch Team
 * @copyright  (c) 2012 Ilch Team
 * @license    http://www.ilch-pluto.net/license
 */
class Ilch_Core extends Kohana_Core {
	
	// CMS Release version and codename
	const CMS_VERSION  = '2.0.0';
	const CMS_CODENAME = 'Pluto';
	
	/**
	 * @var  array   Include paths that are used to find files
	 */
	protected static $_paths = array(APPLICATION_SYSTEM, ILCH_SYSTEM, KOHANA_SYSTEM);
	
	/**
	 * @var  string  Current environment name
	 */
	public static $environment = Ilch::PRODUCTION;
	
	/**
	 * Initializes the environment:
	 *
	 * - Disables register_globals and magic_quotes_gpc
	 * - Determines the current environment
	 * - Set global settings
	 * - Sanitizes GET, POST, and COOKIE variables
	 * - Converts GET, POST, and COOKIE variables to the global character set
	 *
	 * The following settings can be set:
	 *
	 * Type      | Setting    | Description                                    | Default Value
	 * ----------|------------|------------------------------------------------|---------------
	 * `string`  | base_url   | The base URL for your application.  This should be the *relative* path from your DOCROOT to your `index.php` file, in other words, if Kohana is in a subfolder, set this to the subfolder name, otherwise leave it as the default.  **The leading slash is required**, trailing slash is optional.   | `"/"`
	 * `string`  | index_file | The name of the [front controller](http://en.wikipedia.org/wiki/Front_Controller_pattern).  This is used by Kohana to generate relative urls like [HTML::anchor()] and [URL::base()]. This is usually `index.php`.  To [remove index.php from your urls](tutorials/clean-urls), set this to `FALSE`. | `"index.php"`
	 * `string`  | charset    | Character set used for all input and output    | `"utf-8"`
	 * `string`  | cache_dir  | Kohana's cache directory.  Used by [Ilch::cache] for simple internal caching, like [Fragments](kohana/fragments) and **\[caching database queries](this should link somewhere)**.  This has nothing to do with the [Cache module](cache). | `APPPATH."cache"`
	 * `integer` | cache_life | Lifetime, in seconds, of items cached by [Ilch::cache]         | `60`
	 * `boolean` | errors     | Should Kohana catch PHP errors and uncaught Exceptions and show the `error_view`. See [Error Handling](kohana/errors) for more info. <br /> <br /> Recommended setting: `TRUE` while developing, `FALSE` on production servers. | `TRUE`
	 * `boolean` | profile    | Whether to enable the [Profiler](kohana/profiling). <br /> <br />Recommended setting: `TRUE` while developing, `FALSE` on production servers. | `TRUE`	 * `boolean` | caching    | Cache file locations to speed up [Ilch::find_file].  This has nothing to do with [Ilch::cache], [Fragments](kohana/fragments) or the [Cache module](cache).  <br /> <br />  Recommended setting: `FALSE` while developing, `TRUE` on production servers. | `FALSE`
	 *
	 * @throws  Kohana_Exception
	 * @param   array   Array of settings.  See above.
	 * @return  void
	 * @uses    Ilch::globals
	 * @uses    Ilch::sanitize
	 * @uses    Ilch::cache
	 * @uses    Profiler
	 */
	public static function init(array $settings = NULL)
	{
		parent::init($settings);
		
		// Attach the file write to logging. Multiple writers are supported.
		Ilch::$log->attach(new Log_File(APPPATH.'logs'));
		
        // Auto detect base url
        if (!isset($settings['base_url']))
        {
            Ilch::$base_url = preg_replace('/[^\/]+$/', '', $_SERVER['SCRIPT_NAME']);
        }
        
		// Load default modules
		Module_Loader::load((array) Module_Loader::MODULES_DEFAULTS, FALSE, TRUE, FALSE);
		
		// Attach a file reader to config
		Ilch::$config->attach(new Config_File);
		
		// Attach a database reader to config
		Ilch::$config->attach(new Config_Database);

        // Register config groups
        Config_Register::set('system', 'General settings');
        Config_Register::set('system_theme', 'Theme settings');
		
		// Load custom modules
		Module_Loader::load((array) Module_Loader::MODULES_DATABASE);
		
        // Set ilch routes
        Routing::init();
        
        // Set system user auth service
        User_Auth_Service::register('system', __('system_user_service_name'), array(
            'login_view' => 'user/login/system',
        ));
	}
	
	/**
	 * Cleans up the environment:
	 *
	 * - Restore the previous error and exception handlers
	 * - Destroy the Ilch::$log and Ilch::$config objects
	 *
	 * @return  void
	 */
	public static function deinit()
	{
		// Run event
		Event::run('Ilch_Core::deinit::before');
		
		if (Ilch::$_init)
		{
			// Run parent method
			parent::deinit();
			
			// Reset internal storage
			Ilch::set_paths(array(APPLICATION_SYSTEM, ILCH_SYSTEM, KOHANA_SYSTEM));
		}
		
		// Run event
		Event::run('Ilch_Core::deinit::after');
	}
    
    /**
     * Set include paths
     * @param array
     * @return array
     */
    public static function set_paths(array $value)
    {
        Ilch::$_paths = $value;
        return Ilch::get_paths();
    }
    
    /**
     * Get include paths
     * @return array
     */
    public static function get_paths()
    {
        return Ilch::$_paths;
    }
	
	/**
	 * Changes the currently enabled modules. Module paths may be relative
	 * or absolute, but must point to a directory:
	 *
	 *     Ilch::modules(array('modules/foo', MODPATH.'bar'));
	 *
	 * @param   array  list of module paths
	 * @param   bool   ignore missing modules
	 * @param   bool   overload loaded modules
     * @param   bool   auto initialize modules
	 * @return  array  enabled modules
     * @deprecated please use Module_Loader::load($modules, $ignore_missing, $overload, $initialize) and Module_Loader::get_loaded() instead
	 */
	public static function modules(array $modules = NULL, $ignore_missing = TRUE, $overload = FALSE, $initialize = TRUE)
	{
		if ($modules === NULL)
		{
			// Not changing modules, just return the current set
			return Module_Loader::get_loaded();
		}

        return Module_Loader::load($modules, $ignore_missing, $overload, $initialize);
	}
    
    /**
     * Searches for a file in the [Cascading Filesystem](kohana/files), and
     * returns the path to the file that has the highest precedence, so that it
     * can be included.
     *
     * When searching the "config", "messages", or "i18n" directories, or when
     * the `$array` flag is set to true, an array of all the files that match
     * that path in the [Cascading Filesystem](kohana/files) will be returned.
     * These files will return arrays which must be merged together.
     *
     * If no extension is given, the default extension (`EXT` set in
     * `index.php`) will be used.
     *
     *     // Returns an absolute path to views/template.php
     *     Ilch::find_file('views', 'template');
     *
     *     // Returns an absolute path to media/css/style.css
     *     Ilch::find_file('media', 'css/style', 'css');
     *
     *     // Returns an array of all the "mimes" configuration files
     *     Ilch::find_file('config', 'mimes');
     *
     * @param   string   directory name (views, i18n, classes, extensions, etc.)
     * @param   string   filename with subdirectory
     * @param   string   extension to search for
     * @param   boolean  return an array of files?
     * @return  array    a list of files when $array is TRUE
     * @return  string   single file path
     */
    public static function find_file($dir, $file, $ext = NULL, $array = FALSE)
    {
        if ($ext === NULL)
        {
            // Use the default extension
            $ext = EXT;
        }
        elseif ($ext)
        {
            // Prefix the extension with a period
            $ext = ".{$ext}";
        }
        else
        {
            // Use no extension
            $ext = '';
        }

        // Create a partial path of the filename
        $path = $dir.DIRECTORY_SEPARATOR.$file.$ext;

        if (Ilch::$caching === TRUE AND isset(Ilch::$_files[$path.($array ? '_array' : '_path')]))
        {
            // This path has been cached
            return Ilch::$_files[$path.($array ? '_array' : '_path')];
        }

        if (Ilch::$profiling === TRUE AND class_exists('Profiler', FALSE))
        {
            // Start a new benchmark
            $benchmark = Profiler::start('Kohana', __FUNCTION__);
        }

        if ($array OR in_array($dir, array('config', 'i18n', 'messages')))
        {
            // Include paths must be searched in reverse
            $paths = array_reverse(Ilch::$_paths);

            // Array of files that have been found
            $found = array();

            foreach ($paths as $dir)
            {
                if (is_file($dir.$path))
                {
                    // This path has a file, add it to the list
                    $found[] = $dir.$path;
                }
            }
        }
        else
        {
            // The file has not been found yet
            $found = FALSE;

            foreach (Ilch::$_paths as $dir)
            {
                if (is_file($dir.$path))
                {
                    // A path has been found
                    $found = $dir.$path;

                    // Stop searching
                    break;
                }
            }
        }

        // Prepend theme caching
        if (Ilch::$caching === TRUE)
        {
            $is_application_theme = (is_string($found) AND substr($found, 0, strlen(APPLICATION_THEME)) == APPLICATION_THEME);
            $is_ilch_theme = (is_string($found) AND substr($found, 0, strlen(ILCH_THEME)) == ILCH_THEME);
        }

        if (Ilch::$caching === TRUE AND !$is_application_theme AND !$is_ilch_theme)
        {
            // Add the path to the cache
            Ilch::$_files[$path.($array ? '_array' : '_path')] = $found;

            // Files have been changed
            Ilch::$_files_changed = TRUE;
        }
        
        if (isset($benchmark))
        {
            // Stop the benchmark
            Profiler::stop($benchmark);
        }

        return $found;
    }
}