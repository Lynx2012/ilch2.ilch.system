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
			'status' => Jelly::field('enum', array(
                'choices' => array(
					'VERIFICATION',
					'ACTIVE',
					'INACTIVE',
					'BLOCKED'
				),
                'default' => 'VERIFICATION'
            )),
            'registered' => Jelly::field('timestamp', array(
                'format' => 'Y-m-d H:i:s',
				'auto_now_create' => TRUE
            )),
            'last_active' => Jelly::field('timestamp', array(
                'format' => 'Y-m-d H:i:s',
            )),
			'email' => Jelly::field('email', array(
                'label' => 'Email address',
                'unique' => TRUE,
                'filters' => array(
                    array('trim')
                ),
                'rules' => array(
                    array('not_empty'),
                )
            )),
			'nickname' => Jelly::field('string', array(
                'label' => 'Nickname',
                'unique' => TRUE,
                'filters' => array(
                    array('trim')
                ),
                'rules' => array(
                    array('not_empty'),
                )
            )),
			'first_name' => Jelly::field('string', array(
                'label' => 'First name',
                'filters' => array(
                    array('trim')
                )
            )),
			'last_name' => Jelly::field('string', array(
                'label' => 'Last name',
                'filters' => array(
                    array('trim')
                )
            )),
			'config' => Jelly::field('serialized'),

			// Relationships
			'user_auth' => Jelly::field('hasmany', array('foreign' => 'user_auth')),
			'user_auth_service' => Jelly::field('hasmany', array('foreign' => 'user_service')),
			
			'user_group_member' => Jelly::field('hasmany', array('foreign' => 'user_group_member')),
		));

		// Run event
		Event::run('Classes_Model_User::initialize::meta', $meta);
	}

}
