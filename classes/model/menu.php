<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for "menu" table
 *
 * @package    Ilch
 * @category   Core
 * @author     Ilch Team
 * @copyright  (c) 2012 Ilch Team
 * @license    http://www.ilch-pluto.net/license
 */
class Model_Menu extends Jelly_Model {

	/**
	 * Initialize the model
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		// Set table name
		$meta->table('menu');

		// Fields defined by the model
		$meta->fields(array(
			'id' => Jelly::field('primary'),
			'root' => Jelly::field('boolean'),
			'key' => Jelly::field('string'),
			'name' => Jelly::field('boolean'),
		));

		// Run event
		Event::run('Model_Menu::initialize::meta', $meta);
	}

}
