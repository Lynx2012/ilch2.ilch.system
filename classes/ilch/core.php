<?php defined('SYSPATH') or die('No direct script access.');

class Ilch_Core extends Kohana_Core {
	
	/**
	 * @var  array   Include paths that are used to find files
	 */
	protected static $_paths = array(APPLICATION, ILCH_SYSTEM, KOHANA_SYSTEM);
	
	/**
	 * @var  string  Current environment name
	 */
	public static $environment = Ilch::PRODUCTION;
	
	/**
	 * @var  array   Default modules to load on startup
	 */
	protected static $_default_modules = array(
		'application' => array(),
		'contents' => array(),
		'ilch' => array(
			'bootstrap'		=> TRUE,
			'fontawesome'	=> TRUE,
			'jelly'			=> TRUE,
		),
		'kohana' => array(
			'auth'		=> FALSE,
			'cache'		=> array('PRODUCTION', 'STAGING'),
			'codebench'	=> 'DEVELOPMENT',
			'database'	=> TRUE,
			'image'		=> FALSE,
			'orm'		=> FALSE,
			'unittest'	=> 'DEVELOPMENT',
			'userguide'	=> array('TESTING', 'DEVELOPMENT'),
		),
	);
	
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
		
		// Merge custom default modules
		if (isset($settings['default_modules']) AND is_array($settings['default_modules']))
		{
			foreach ($settings['default_modules'] AS $key => $val)
			{
				Ilch::$_default_modules[$key] = array_merge(Ilch::$_default_modules[$key], $val);
			}
		}
		
		// Load default modules
		Ilch::_load_default_modules();
		
		// Attach a file reader to config
		Ilch::$config->attach(new Config_File);
		
		// Attach a database reader to config
		//Ilch::$config->attach(new Config_Database);
		
		// Initialize all modules
		Ilch::init_modules();
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
		if (Ilch::$_init)
		{
			// Run parent method
			parent::deinit();
			
			// Reset internal storage
			Ilch::$_paths   = array(APPLICATION, ILCH_SYSTEM, KOHANA_SYSTEM);
		}
	}
	
	/**
	 * Read and load default modules
	 * 
	 * @return Ilch::modules()
	 */
	protected static function _load_default_modules()
	{
		// Create empty module array
		$modules = array();
		
		// Collect modules
		foreach(Ilch::$_default_modules AS $key => $val)
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
				}
				
				// Save module
				if ($check)
				{
					$modules[strtolower($key.'_module_'.$name)] = constant(strtoupper($key.'_MODULE')).$name;
				}
			}
		}
		
		// Load modules
		return Ilch::modules($modules, FALSE);
	}
	
	/**
	 * Changes the currently enabled modules. Module paths may be relative
	 * or absolute, but must point to a directory:
	 *
	 *     Ilch::modules(array('modules/foo', MODPATH.'bar'));
	 *
	 * @param   array  list of module paths
	 * @param   bool   ignore missing modules
	 * @return  array  enabled modules
	 */
	public static function modules(array $modules = NULL, $ignore_missing = TRUE)
	{
		if ($modules === NULL)
		{
			// Not changing modules, just return the current set
			return Ilch::$_modules;
		}

		// Start a new list of include paths, APPPATH first
		$paths = array(APPLICATION);

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
		Ilch::$_paths = $paths;

		// Set the current module list
		Ilch::$_modules = $modules;

		return Ilch::$_modules;
	}

	/**
	 * Initialize all modules
	 * 
	 * @return void
	 */
	public static function init_modules()
	{
		foreach (Ilch::$_modules as $path)
		{
			$init = $path.'init'.EXT;

			if (is_file($init))
			{
				// Include the module initialization file once
				require_once $init;
			}
		}
	}
}