<?php defined('SYSPATH') or die('No direct script access.');

class Widget_Backend_Navigation {
    
    protected static $_groups = array(
        'main'   => FALSE, // Like dashboard
        'module' => FALSE, // Like blog, forum,..
        'content' => FALSE, // Like own sites and widgets
        'user' => FALSE, // Like permissions and user management
        'config' => FALSE // Like Modules, themes, settings
    );
    
    /**
     * Get a group
     * 
     * @param string $group
     * @return Template_Backend_Navigation
     * @throws Kohana_Exception
     */
    public static function group($group)
    {
        if (!isset(Widget_Backend_Navigation::$_groups[$group]))
            throw new Kohana_Exception('The backend navigation group "'.$group.'" does not exists');
        
        if (Widget_Backend_Navigation::$_groups[$group] === FALSE)
            Widget_Backend_Navigation::$_groups[$group] = new Widget_Backend_Navigation_Element();
        
        return Widget_Backend_Navigation::$_groups[$group];
    }
    
}