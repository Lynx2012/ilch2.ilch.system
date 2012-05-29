<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Media extends Controller {
 
	public function action_index()
	{
		// Get File Status, Header and Body
		Media::controller($this->request, $this->response, $this->request->param('file'));
	}

}
