<?php

defined('SYSPATH') or die('No direct script access.');

abstract class Ilch_Controller_Template extends Kohana_Controller_Template {

    /**
     * Initialize properties before running the controller methods (actions),
     * so they are available to our action.
     */
    public function before()
    {
        if (!$this->request->is_initial())
        {
            $this->auto_render = FALSE;
            $this->template = new stdClass();
        }
        
        // Run anything that need to run before this.
        parent::before();       

        // Run event
        Event::run('Classes_Ilch_Controller_Template::before::before', $this);
        
        if ($this->auto_render)
        {
            // Initialize empty values
            $this->template->title = '';
            $this->template->meta = array();
            $this->template->styles = array();
            $this->template->scripts = array();
            $this->template->content = '';
        }
        
        // Run event
        Event::run('Classes_Ilch_Controller_Template::before::after', $this);
    }

    /**
     * Fill in default values for our properties before rendering the output.
     */
    public function after()
    {
        // Run event
        Event::run('Classes_Ilch_Controller_Template::after::before', $this);
        
        // Run anything that needs to run after this.
        parent::after();
        
        if (!$this->request->is_initial() AND ! $this->auto_render)
        {
            $this->response->body($this->template->content);
        }
        
        // Run event
        Event::run('Classes_Ilch_Controller_Template::after::after', $this);
    }
    
}