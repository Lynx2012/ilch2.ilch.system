<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Module manager class
 *
 * @package    Ilch
 * @category   Core/Module
 * @author     Ilch Team
 * @copyright  (c) 2012 Ilch Team
 * @license    http://www.ilch-pluto.net/license
 */
abstract class Ilch_Content_Manager {
	
	const META_DETAILS = 'details';
    const META_HISTORY = 'history';
    
    /**
     * Get path to module, theme or other content
     * @param string like "module" or "theme"
     * @param string like "ilch", "kohana" or "application"
     * @param string
     * @return string
     */
	public static function find($paths, $name)
	{
		foreach ($paths AS $path)
		{
			if (is_dir($dir = $path.DS.$name)) return $dir;
		}
		return FALSE;
	}
    
	public static function meta($path, $meta_file = NULL)
    {
        // Set default meta file
        if ($meta_file === NULL)
            $meta_file = Content_Manager::META_DETAILS;
        
        // Define file path
        $file = $path.DS.'meta'.DS.$meta_file.EXT;
        
        if (!file_exists($file))
            return NULL;
        
        return include $file;
    }
}
