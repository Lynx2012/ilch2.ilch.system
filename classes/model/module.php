<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for "modules" table
 *
 * @package    Ilch/Core
 * @category   Modules
 * @author     Ilch Team
 * @copyright  (c) 2012 Ilch Team
 * @license    http://www.ilch-pluto.net/license
 */
class Model_Module extends Jelly_Model {

	/**
	 * Initialize the model
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		// Set table name
		$meta->table('module');

		// Fields defined by the model
		$meta->fields(array(
			'id' => Jelly::field('primary'),
			'name' => Jelly::field('string'),
			'version' => Jelly::field('string'),
			'installed' => Jelly::field('boolean'),
			'activated' => Jelly::field('boolean'),
			'position' => Jelly::field('float'),
		));

		// Run event
		Event::run('Model_Module::initialize::meta', $meta);
	}

}
