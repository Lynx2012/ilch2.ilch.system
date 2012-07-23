<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend_Test extends Template_Frontend {

    public function action_index()
    {
        var_dump(Route::get('media')->uri(array(
          'directory' => 'user',
        )));
    }

}