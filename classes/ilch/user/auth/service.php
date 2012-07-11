<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Auth service management class
 *
 * @package    Ilch
 * @category   User
 * @author     Ilch Team
 * @copyright  (c) 2012 Ilch Team
 * @license    http://www.ilch-pluto.net/license
 */
class Ilch_User_Auth_Service {
    
    public static $services = array();
    
    /**
     * Register an auth service
     * 
     *     User_Auth_Service::register('myservice', 'My Login Service', array(
     *         'description' => 'This is realy cool.',
     *         'login_view' => 'user/auth/service/myservice',
     *         'login_page' => 'user/login/myservice',
     *         'registration_page' => 'user/registration/myservice'
     *     );
     * 
     * 
     * @param string $key
     * @param string $name
     * @param array $options
     * @throws Kohana_Exception
     */
    public static function register($key, $name, $options = array())
    {
        if (isset(User_Auth_Service::$services[$key]))
            throw new Kohana_Exception('Service key '.$key.' already exists.');
        
        User_Auth_Service::$services[$key] = array(
            'name' => $name
        )+$options;
    }
    
}
