<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Ilch routing class contain all routes by ilch_system
 */
class Ilch_Core_Routing {
    
    public static function init()
    {
        // Media controller
        Route::set('media', '(<directory>/)media(/<file>)', array('file' => '.+'))
            ->defaults(array(
                'controller' => 'media',
                'action'     => 'index',
                'file'       => NULL,
            ));
        
        // Set default ilch route
        Route::set('default', array('Ilch_Routing', 'dynamic'));
    }
    
    /**
     * Dynamic Ilch CMS route
     * @param string given url
     * @return array
     */
    public static function dynamic($uri)
    {
        // Defaults
        $return_arr = array();
        
        // If Backend
        if (preg_match('#^backend(?:/(?P<controller>[^/.,;?\n]++)(?:/(?P<action>[^/.,;?\n]++)(?:/(?P<overflow>(.*?)))?)?)?$#uD', $uri, $match))
        {
            // Directory
            $return_arr['directory'] = 'backend';
            
            // Controller
            $return_arr['controller'] = (isset($match[1]) === TRUE) ? $match[1] : 'dashboard';
            
            // Action
            $return_arr['action'] = (isset($match[2]) === TRUE) ? $match[2] : 'index';
            
            // Overflow
            $return_arr += (isset($match[3]) === TRUE) ? explode('/', $match[3]) : array();
        }
        // If Frontend
        elseif (preg_match('#^(?:(?P<controller>[^/.,;?\n]++)(?:/(?P<action>[^/.,;?\n]++)(?:/(?P<overflow>(.*?)))?)?)?$#uD', $uri, $match))
        {
            // Directory
            $return_arr['directory'] = 'frontend';
            
            // Controller
            $return_arr['controller'] = (isset($match[1]) === TRUE) ? $match[1] : Ilch::$config->load('system')->get('index_controller');
            
            // Action
            $return_arr['action'] = (isset($match[2]) === TRUE) ? $match[2] : 'index';
            
            // Overflow
            $return_arr += (isset($match[3]) === TRUE) ? explode('/', $match[3]) : array();
        }
        
        // Return Route-Array
        if ($return_arr == TRUE) return $return_arr;
    }
    
}
