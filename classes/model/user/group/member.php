<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for "user_group_member" table
 *
 * @package    Ilch/Core
 * @category   User
 * @author     Ilch Team
 * @copyright  (c) 2012 Ilch Team
 * @license    http://www.ilch-pluto.net/license
 */
class Model_User_Group_Member extends Jelly_Model
{
    public static function initialize(Jelly_Meta $meta)
    {
    	// Set table name
    	$meta->table('user_group_member');
		
        // Fields defined by the model
        $meta->fields(array(
            'id'			=> Jelly::field('primary'),
            'group_id' 		=> Jelly::field('integer'),
            'user_id'       => Jelly::field('integer'),
        ));
		
		// Run event
		Event::run('Model_User_Group_Member::initialize::after', $meta);
    }
}