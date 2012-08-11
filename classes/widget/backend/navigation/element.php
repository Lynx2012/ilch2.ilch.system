<?php defined('SYSPATH') or die('No direct script access.');

class Widget_Backend_Navigation_Element extends Widget_Backend_Navigation {
    
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
        // Set text
        if (isset($options['text']))
            $this->set_text ($options['text']);
        
        // Set icon
        if (isset($options['icon']))
            $this->set_text ($options['icon']);
        
        // Set url
        if (isset($options['url']))
            $this->set_text ($options['url']);
        
        // Set count
        if (isset($options['count']))
            $this->set_text ($options['count']);
        
        // Set active
        if (isset($options['active']))
            $this->set_text ($options['active']);
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
     * @param string $key
     * @param array $options
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
	 * Set text
	 * @param string $val
	 * @return Template_Backend_Navigation 
	 */
	public function set_text($val)
	{
		$this->_text = $val;
		return $this;
	}
	
    /**
     * Get text
     * @return string
     */
	public function get_text()
	{
		return $this->_text;
	}
	
    /**
     * Set icon name
     * @param string $val
     * @return Template_Backend_Navigation
     */
	public function set_icon($val)
	{
		$this->_icon = $val;
		return $this;
	}
	
    /**
     * Get icon name
     * @return string
     */
	public function get_icon()
	{
		return $this->_icon;
	}
	
    /**
     * Set url
     * @param string $val
     * @return Template_Backend_Navigation
     */
	public function set_url($val)
	{
		$this->_url = $val;
		return $this;
	}
    
    /**
     * Get url
     * @return string
     */
    public function get_url()
	{
		return $this->_url;
	}
	
    /**
     * Set count
     * @param int $val
     * @return Template_Backend_Navigation
     */
	public function set_count($val)
	{
		$this->_count = $val;
		return $this;
	}
	
    /**
     * Get count
     * @return int
     */
	public function get_count()
	{
		return $this->_count;
	}
	
    /**
     * Set active status
     * @param bool $val
     * @return Template_Backend_Navigation
     */
	public function set_active($val)
	{
		$this->_active = $val;
		return $this;
	}
	
    /**
     * Get active status
     * @return bool
     */
	public function get_active()
	{
		return $this->_active;
	}
}