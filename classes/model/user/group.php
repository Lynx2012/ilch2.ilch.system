<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for "user_group" table
 *
 * @package    Ilch/Core
 * @category   User
 * @author     Ilch Team
 * @copyright  (c) 2012 Ilch Team
 * @license    http://www.ilch-pluto.net/license
 */
class Model_User_Service extends Jelly_Model
{
    public static function initialize(Jelly_Meta $meta)
    {
    	// Set table name
    	$meta->table('user_group');
		
        // Fields defined by the model
        $meta->fields(array(
            'id'			=> Jelly::field('primary'),
            'root'  		=> Jelly::field('integer'),
            'translate'		=> Jelly::field('integer'),
            'name'          => Jelly::field('string'),
            'description'   => Jelly::field('string'),
            'permission'    => Jelly::field('serialize'),
        ));
		
		// Run event
		Event::run('Model_User_Group::initialize::after', $meta);
    }
}