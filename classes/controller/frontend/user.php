<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend_User extends Controller_Frontend_Template {

    public function action_login()
    {
        // Default login
        $this->template->content = View::factory('user/login');
        
    }
    
    public function action_logout()
    {
        // Logout
        $this->template->content = View::factory('user/logout');
    }

}