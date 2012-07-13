<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_Template extends Controller_Template {

    // Festlegen des Templates
    public $template = 'backend/index';

    public function before()
    {       
        // Run event
        Event::run('Controller_Backend_Template::before::before', $this);
        
        // Load frontend theme
        Content_Theme_Loader::load(Content_Theme_Loader::THEME_BACKEND);
        
        // Run anything that need ot run before this
        parent::before();

        if ($this->auto_render)
        {
            // Submenu - Tabs
            $this->template->tab_list = array();
            
            // Active tab key
            $this->template->tab_active = NULL;
            
            // Section icon
            $this->template->icon = NULL;
            
        	// Get configuration
            $config = Ilch::$config->load('theme')->get('backend');
			
            // Add Styles by Config
            if (is_array($config['media']['styles']) && count($config['media']['styles']) >= 1)
            {
                $this->template->styles = array_merge($this->template->styles, $config['media']['styles']);
            }
        }
        
        // Run event
        Event::run('Controller_Backend_Template::before::after', $this);
    }

    public function after()
    {
        // Run event
        Event::run('Controller_Backend_Template::after::before', $this);
        
        // Run anything that needs to run after this.
        parent::after();
        
        // Run event
        Event::run('Controller_Backend_Template::after::after', $this);
    }

}