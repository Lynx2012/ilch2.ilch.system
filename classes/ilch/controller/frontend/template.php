<?php defined('SYSPATH') or die('No direct script access.');

class Ilch_Controller_Frontend_Template extends Controller_Template {

    // Festlegen des Templates
    public $template = 'frontend/index';

    public function before()
    {
        // Run event
        Event::run('Classes_Ilch_Controller_Frontend_Template::before::before', $this);
        
        // Load frontend theme
        Content_Theme_Loader::load(Content_Theme_Loader::THEME_FRONTEND);
        
        // Run anything that need ot run before this
        parent::before();
        
        if ($this->auto_render)
        {
        	// Get configuration
            $config = Ilch::$config->load('theme')->get('frontend');
			
            // Add Styles by Config
            if (is_array($config['media']['styles']) && count($config['media']['styles']) >= 1)
            {
                $this->template->styles = array_merge($this->template->styles, $config['media']['styles']);
            }
        }
        
        // Run event
        Event::run('Classes_Ilch_Controller_Frontend_Template::before::after', $this);
    }

    public function after()
    {
        // Run event
        Event::run('Classes_Ilch_Controller_Frontend_Template::after::before', $this);
        
        // Run anything that needs to run after this.
        parent::after();
        
        // Run event
        Event::run('Classes_Controller_Frontend_Template::after::after', $this);
    }

}