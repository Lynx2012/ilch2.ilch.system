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
class Ilch_Theme_Loader extends Content_Loader {
	
	const LOADER_NAME = 'theme';
	
    const THEME_BACKEND = 'backend';
    const THEME_FRONTEND = 'frontend';
	
	const THEME_DEFAULT = 'pluto';
	
	/**
	 * @var array Paths to search themes
	 */
	public static $paths = array();
    
    /**
     * Load a theme
     * @param array
     * @return bool load status
     */
    public static function load($type)
    {
        // Set default theme
        $key = Theme_Loader::name(Theme_Loader::LOADER_NAME, Theme_Loader::THEME_DEFAULT);
		$value = Theme_Loader::find(Theme_Loader::$paths, Theme_Loader::THEME_DEFAULT);
        $default = array($key => $value);
        
        // Get ilch system configuration
        $config = Ilch::$config->load('ilch_system');

        // Frontend theme
        if ($type == Theme_Loader::THEME_FRONTEND)
        {
            // Get active theme
            $active = intval($config->get('theme_frontend'));
        }
        // Backend theme
        elseif ($type == Theme_Loader::THEME_FRONTEND)
        {
            // Get active theme
            $active = intval($config->get('theme_backend'));
        }
        // Set default theme
        else
        {
            $theme = $default;
        }
        
        if (isset($active))
        {
            // Find the theme in the database
            $select = Jelly::query('theme', $active)->installed()->select();
             
            if ($select->loaded())
            {
		        $key = Theme_Loader::name(Theme_Loader::LOADER_NAME, $select->name);
				$value = Theme_Loader::find(Theme_Loader::$paths, $select->name);
                $theme = array($key => $value);
				
		        // If index not exists set default
		        if (!is_file($value.DS.implode(DS, array('views', $type, 'index.php'))))
		        {
		            $theme = $default;
		        }
            }
			else
			{
				$theme = $default;
			}
			
        }
        
        // Set to module list
        Theme_Loader::_load($theme);
        
        // Theme successfully loaded
        return TRUE;
    }
}
