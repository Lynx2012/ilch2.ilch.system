<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for "user_auth_service" table
 *
 * @package    Ilch/Core
 * @category   User
 * @author     Ilch Team
 * @copyright  (c) 2012 Ilch Team
 * @license    http://www.ilch-pluto.net/license
 */
class Model_User_Auth_Service extends Jelly_Model {

	/**
	 * Initialize the model
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		// Set table name
		$meta->table('user_auth_service');

		// Fields defined by the model
		$meta->fields(array(
			'id' => Jelly::field('primary'),
			'service' => Jelly::field('string'),
            'name' => Jelly::field('string'),
			'auth_token' => Jelly::field('string'),

			// Relationships
			'user' => Jelly::field('belongsto', array(
				'column' => 'user_id',
				'foreign' => 'user',
			)),
		));

		// Run event
		Event::run('Classes_Model_User_Auth_Service::initialize::meta', $meta);
	}

}
