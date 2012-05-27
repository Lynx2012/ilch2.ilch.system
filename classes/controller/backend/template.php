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
        Theme_Loader::load((array) Theme_Loader::THEME_BACKEND);
        
        // Run anything that need ot run before this
        parent::before();

        if ($this->auto_render)
        {
            // Add Styles by Config
            $theme_styles = Ilch::$config->load('theme')->backend['media']['styles'];
            if (is_array($theme_styles) && count($theme_styles) >= 1)
            {
                $this->template->styles = array_merge($this->template->styles, $theme_styles);
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