<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Template_Backend extends Controller_Template_General {

	// Festlegen des Templates
	public $template = 'index';

	public function before()
	{
		// Run anything that need ot run before this.
		parent::before();
		
		if ($this->auto_render)
		{
			// Add Styles by Config
			$theme_styles = Kohana::$config->load('theme')->backend['media']['styles'];
			if (is_array($theme_styles) && count($theme_styles) >= 1)
			{
				$this->template->styles = array_merge($this->template->styles, $theme_styles);
			}
		}
	}

	public function after()
	{
		// Run anything that needs to run after this.
		parent::after();
	}

}