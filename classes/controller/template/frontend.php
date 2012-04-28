<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Template_Frontend extends Controller_Template_General {

	// Festlegen des Templates
	public $template = 'index';

	public function before()
	{
		// Run event
		Event::run('Controller_Template_Frontend::before::before', $this);
		
		// Run anything that need ot run before this.
		parent::before();
		
		if ($this->auto_render)
		{
			// Add Styles by Config
			$theme_styles = Kohana::$config->load('theme')->frontend['media']['styles'];
			if (is_array($theme_styles) && count($theme_styles) >= 1)
			{
				$this->template->styles = array_merge($this->template->styles, $theme_styles);
			}
		}
		
		// Run event
		Event::run('Controller_Template_Frontend::before::after', $this);
	}

	public function after()
	{
		// Run event
		Event::run('Controller_Template_Frontend::after::before', $this);
		
		// Run anything that needs to run after this.
		parent::after();
		
		// Run event
		Event::run('Controller_Template_Frontend::after::after', $this);
	}

}