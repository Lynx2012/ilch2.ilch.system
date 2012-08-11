<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Initialize ilch user system
 */
class Ilch_Init_User {
    
    public static function init()
    {
        // Set system user auth service
        User_Auth_Service::register('system', __('system_user_service_name'), array(
            'login_view' => 'frontend/user/login/system',
        ));
    }
    
}
