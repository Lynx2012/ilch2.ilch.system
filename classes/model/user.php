<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for "user" table
 *
 * @package    Ilch/Core
 * @category   User
 * @author     Ilch Team
 * @copyright  (c) 2012 Ilch Team
 * @license    http://www.ilch-pluto.net/license
 */
class Model_User extends Jelly_Model {

	/**
	 * Initialize the model
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		// Set table name
		$meta->table('user');

		// Fields defined by the model
		$meta->fields(array(
			'id' => Jelly::field('primary'),
			'status' => Jelly::field('enum', array('choices' => array(
					'VERIFICATION',
					'ACTIVE',
					'INACTIVE',
					'BLOCKED'
				))),
			'email' => Jelly::field('email'),
			'nickname' => Jelly::field('string'),
			'first_name' => Jelly::field('string'),
			'last_name' => Jelly::field('string'),
			'config' => Jelly::field('serialize'),

			// Relationships
			'user_auth' => Jelly::field('hasmany', array('foreign' => 'user_auth')),
			'user_group_member' => Jelly::field('hasmany', array('foreign' => 'user_group_member')),
			'user_service' => Jelly::field('hasmany', array('foreign' => 'user_service'))
		));

		// Run event
		Event::run('Model_User::initialize::after', $meta);
	}

}
