<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Template_General extends Controller_Template {

	/**
	 * Initialize properties before running the controller methods (actions),
	 * so they are available to our action.
	 */
	public function before()
	{
		// Run anything that need to run before this.
		parent::before();		

		// Run event
		Event::run('Controller_Template_General::before::before', $this);
		
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
		Event::run('Controller_Template_General::before::after', $this);
	}

	/**
	 * Fill in default values for our properties before rendering the output.
	 */
	public function after()
	{
		// Run event
		Event::run('Controller_Template_General::after::before', $this);
		
		// Run anything that needs to run after this.
		parent::after();
		
		// Run event
		Event::run('Controller_Template_General::after::after', $this);
	}
	
}