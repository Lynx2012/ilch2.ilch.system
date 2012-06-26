<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for "user_auth" table
 *
 * @package    Ilch/Core
 * @category   User
 * @author     Ilch Team
 * @copyright  (c) 2012 Ilch Team
 * @license    http://www.ilch-pluto.net/license
 */
class Model_User_Auth extends Jelly_Model
{
    public static function initialize(Jelly_Meta $meta)
    {
    	// Set table name
    	$meta->table('user_auth');
		
        // Fields defined by the model
        $meta->fields(array(
            'id'			=> Jelly::field('primary'),
            'user_id'  		=> Jelly::field('integer'),
            'created'		=> Jelly::field('integer'),
            'user_agent'    => Jelly::field('string'),
            'auth_token'    => Jelly::field('string'),
        ));
		
		// Run event
		Event::run('Model_User_Auth::initialize::after', $meta);
    }
}