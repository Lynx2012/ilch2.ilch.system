<?php defined('SYSPATH') or die('No direct script access.');

class Ilch_Template_Backend_Navigation {
    
    protected static $_groups = array(
        'main'   => NULL, // Like dashboard
        'module' => NULL, // Like blog, forum,..
        'content' => NULL, // Like own sites and widgets
        'user' => NULL, // Like permissions and user management
        'config' => NULL // Like Modules, themes, settings
    );
    
    protected $_text = NULL;
    protected $_icon = NULL;
    protected $_url = NULL;
    protected $_count = NULL;
    protected $_active = NULL;
    protected $_children = array();

    public function __construct($options = array())
    {
        
    }
    
    /**
     * Get a group
     * 
     * @param string $group
     * @return Template_Backend_Navigation
     * @throws Kohana_Exception
     */
    public static function group($group)
    {
        if (!isset(Template_Backend_Navigation::$_groups[$group]))
            throw new Kohana_Exception('The backend navigation group "'.$group.'" does not exists');
        
        if (Template_Backend_Navigation::$_groups[$group] === NULL)
            Template_Backend_Navigation::$_groups[$group] = new Template_Backend_Navigation();
        
        return Template_Backend_Navigation::$_groups[$group];
    }
    
    /**
     * Create a new navigation element
     * 
     * @param type $key
     * @param type $options
     */
    public function set($key, $options = array())
    {
        
    }

    /**
     * Get an navigation element
     * 
     * @param string $key
     * @return Template_Backend_Navigation
     * @throws Kohana_Exception
     */
    public function get($key)
    {
        return $this->get_children($key);
    }
    
    public function get_children($key = NULL)
    {
        
    }
    
    
}