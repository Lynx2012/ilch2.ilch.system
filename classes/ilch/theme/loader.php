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
	
    const THEME_BACKEND = 'backend';
    const THEME_FRONTEND = 'frontend';
	
	/**
	 * @var array Paths to search themes
	 */
	public static $paths = array();
    
    /**
     * Set theme load status
     * @param bool
     * @return string
     */
    protected static function _set_is_loaded($value)
    {
        Theme_Loader::$_is_loaded = $value;
        return Theme_Loader::_get_is_loaded();
    }
    
    /**
     * Get theme load status
     * @return string
     */
    protected static function _get_is_loaded()
    {
        return Theme_Loader::$_is_loaded;
    }
    
    /**
     * Load a theme
     * @param array
     * @return bool load status
     */
    public static function load(array $theme)
    {
        // Theme is already loaded
        if (Theme_Loader::_get_is_loaded() OR !is_array($theme) OR !$theme) return FALSE;
        
        // Set default theme
        $default = array('theme' => Theme_Loader::path('theme', 'ilch', 'pluto'));
        
        if (isset($theme[0]))
        {
            // Get ilch system configuration
            $config = Ilch::$config->load('ilch_system');
            
            // Frontend theme
            if ($theme[0] == Theme_Loader::THEME_FRONTEND)
            {
                // Get active theme
                $active = (isset($config->theme_frontend)) ? $config->theme_frontend : 0;
            }
            // Backend theme
            elseif ($theme[0] == Theme_Loader::THEME_FRONTEND)
            {
                // Get active theme
                $active = (isset($config->theme_backend)) ? $config->theme_backend : 0;
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
                    $theme = array('theme' => Theme_Loader::path('theme', $select->source, $select->name));
                }
            }
        }
        
        // If theme not exists set default
        if (!is_dir(current($theme)))
        {
            $theme = $default;
        }
        
        // Set theme status
        Theme_Loader::_set_is_loaded(TRUE);
        
        // Set to module list
        Theme_Loader::_load($theme);
        
        // Theme successfully loaded
        return TRUE;
    }
}
