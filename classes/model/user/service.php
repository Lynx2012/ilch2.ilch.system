<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for "user_service" table
 *
 * @package    Ilch/Core
 * @category   User
 * @author     Ilch Team
 * @copyright  (c) 2012 Ilch Team
 * @license    http://www.ilch-pluto.net/license
 */
class Model_User_Service extends Jelly_Model {

	/**
	 * Initialize the model
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		// Set table name
		$meta->table('user_service');

		// Fields defined by the model
		$meta->fields(array(
			'id' => Jelly::field('primary'),
			'service' => Jelly::field('string'),
			'auth_token' => Jelly::field('string'),

			// Relationships
			'user' => Jelly::field('belongsto', array(
				'column' => 'user_id',
				'foreign' => 'user',
			)),
		));

		// Run event
		Event::run('Model_User_Service::initialize::after', $meta);
	}

}
