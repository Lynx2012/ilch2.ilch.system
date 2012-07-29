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

	/**
	 * Create a new navigation element
	 * 
	 * Possible options:
	 * - text
	 * - icon
	 * - url
	 * - count
	 * - active
	 * 
	 * @param type $options
	 */
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
	 * Set children elements
	 * 
	 * @param array $val
	 * @return Template_Backend_Navigation
	 */
	public function set_children($val)
	{
		$this->_children = $val;
		return $this;
	}
	
    /**
     * Create a new navigation element
     * 
     * @param type $key
     * @param type $options
	 * @return Template_Backend_Navigation
     */
    public function add_children($key, $options = array())
    {
        if (isset($this->_children[$key]))
			throw new Kohana_Exception(sprintf('The children %s already exists', $key));
		
		return $this->_children[$key] = new Template_Backend_Navigation($options);
    }
	
    /**
     * Get one or all navigation element(s)
     * 
     * @param string $key
     * @return Template_Backend_Navigation
     * @throws Kohana_Exception
     */
    public function get_children($key = NULL)
    {
        if ($key !== NULL AND !isset($this->_children[$key]))
			throw new Kohana_Exception(sprintf('The children %s does not exits', $key));
		
		if ($key !== NULL)
			return $this->_children[$key];
		
		return $this->_children;
    }
	
	/**
	 * 
	 * 
	 * @param type $val
	 * @return Template_Backend_Navigation 
	 */
	public function set_text($val)
	{
		$this->_text = $val;
		return $this;
	}
	
	public function get_text()
	{
		return $this->_text;
	}
	
	public function set_icon($val)
	{
		$this->_icon = $val;
		return $this;
	}
	
	public function get_icon()
	{
		return $this->_icon;
	}
	
	public function set_url($val)
	{
		$this->_url = $val;
		return $this;
	}
    
    public function get_url()
	{
		return $this->_url;
	}
	
	public function set_count($val)
	{
		$this->_count = $val;
		return $this;
	}
	
	public function get_count()
	{
		return $this->_count;
	}
	
	public function set_active($val)
	{
		$this->_active = $val;
		return $this;
	}
	
	public function get_active()
	{
		return $this->_active;
	}
}