<?php defined('SYSPATH') or die('No direct script access.');

class Ilch_Core extends Kohana_Core {
	
	protected static $_paths = array(APPPATH, ILCH_SYSPATH, SYSPATH);
	
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
	 * `string`  | cache_dir  | Kohana's cache directory.  Used by [Kohana::cache] for simple internal caching, like [Fragments](kohana/fragments) and **\[caching database queries](this should link somewhere)**.  This has nothing to do with the [Cache module](cache). | `APPPATH."cache"`
	 * `integer` | cache_life | Lifetime, in seconds, of items cached by [Kohana::cache]         | `60`
	 * `boolean` | errors     | Should Kohana catch PHP errors and uncaught Exceptions and show the `error_view`. See [Error Handling](kohana/errors) for more info. <br /> <br /> Recommended setting: `TRUE` while developing, `FALSE` on production servers. | `TRUE`
	 * `boolean` | profile    | Whether to enable the [Profiler](kohana/profiling). <br /> <br />Recommended setting: `TRUE` while developing, `FALSE` on production servers. | `TRUE`	 * `boolean` | caching    | Cache file locations to speed up [Kohana::find_file].  This has nothing to do with [Kohana::cache], [Fragments](kohana/fragments) or the [Cache module](cache).  <br /> <br />  Recommended setting: `FALSE` while developing, `TRUE` on production servers. | `FALSE`
	 *
	 * @throws  Kohana_Exception
	 * @param   array   Array of settings.  See above.
	 * @return  void
	 * @uses    Kohana::globals
	 * @uses    Kohana::sanitize
	 * @uses    Kohana::cache
	 * @uses    Profiler
	 */
	public static function init(array $settings = NULL)
	{
		parent::init($settings);
	}
	
	/**
	 * Cleans up the environment:
	 *
	 * - Restore the previous error and exception handlers
	 * - Destroy the Kohana::$log and Kohana::$config objects
	 *
	 * @return  void
	 */
	public static function deinit()
	{
		if (Kohana::$_init)
		{
			// Run parent method
			parent::deinit();
			
			// Reset internal storage
			Kohana::$_paths   = array(APPPATH, ILCH_SYSPATH, SYSPATH);
		}
	}
	
	/**
	 * Changes the currently enabled modules. Module paths may be relative
	 * or absolute, but must point to a directory:
	 *
	 *     Kohana::modules(array('modules/foo', MODPATH.'bar'));
	 *
	 * @param   array  list of module paths
	 * @return  array  enabled modules
	 */
	public static function modules(array $modules = NULL)
	{
		if ($modules === NULL)
		{
			// Not changing modules, just return the current set
			return Kohana::$_modules;
		}

		// Start a new list of include paths, APPPATH first
		$paths = array(APPPATH);

		foreach ($modules as $name => $path)
		{
			if (is_dir($path))
			{
				// Add the module to include paths
				$paths[] = $modules[$name] = realpath($path).DS;
			}
			else
			{
				// This module is invalid, remove it
				throw new Kohana_Exception('Attempted to load an invalid or missing module \':module\' at \':path\'', array(
					':module' => $name,
					':path'   => Debug::path($path),
				));
			}
		}

		// Finish the include paths by adding ILCH_SYSPATH and SYSPATH
		$paths[] = ILCH_SYSPATH;
		$paths[] = SYSPATH;

		// Set the new include paths
		Kohana::$_paths = $paths;

		// Set the current module list
		Kohana::$_modules = $modules;

		foreach (Kohana::$_modules as $path)
		{
			$init = $path.'init'.EXT;

			if (is_file($init))
			{
				// Include the module initialization file once
				require_once $init;
			}
		}

		return Kohana::$_modules;
	}
}