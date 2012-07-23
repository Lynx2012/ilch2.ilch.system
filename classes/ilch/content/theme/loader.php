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
class Ilch_Content_Theme_Loader extends Content_Loader {
	
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
        $key = Content_Theme_Loader::name(Content_Theme_Loader::LOADER_NAME, Content_Theme_Loader::THEME_DEFAULT);
	$value = Content_Theme_Manager::find(Content_Theme_Loader::$paths, Content_Theme_Loader::THEME_DEFAULT);
        $default = array($key => $value);
        
        // Get ilch system configuration
        $config = Ilch::$config->load('system_theme');

        // Frontend theme
        if ($type == Content_Theme_Loader::THEME_FRONTEND)
        {
            // Get active theme
            $active = intval($config->get('frontend'));
        }
        // Backend theme
        elseif ($type == Content_Theme_Loader::THEME_FRONTEND)
        {
            // Get active theme
            $active = intval($config->get('backend'));
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
		        $key = Content_Theme_Loader::name(Content_Theme_Loader::LOADER_NAME, $select->name);
				$value = Content_Theme_Manager::find(Content_Theme_Loader::$paths, $select->name);
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
        Content_Theme_Loader::_load($theme);
        
        // Theme successfully loaded
        return TRUE;
    }
}
