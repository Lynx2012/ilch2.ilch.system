<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for "theme" table
 *
 * @package    Ilch/Core
 * @category   Modules
 * @author     Ilch Team
 * @copyright  (c) 2012 Ilch Team
 * @license    http://www.ilch-pluto.net/license
 */
class Ilch_Model_Theme extends Jelly_Model
{
    public static function initialize(Jelly_Meta $meta)
    {
    	// Set table name
    	$meta->table('theme');
		
        // Fields defined by the model
        $meta->fields(array(
            'id'			=> Jelly::field('primary'),
            'source'		=> Jelly::field('string'),
            'name'			=> Jelly::field('string'),
            'version'		=> Jelly::field('string'),
            'installed'		=> Jelly::field('boolean'),
        ));
		
		// Run event
		Event::run('Model_Theme::initialize::after', $meta);
    }
}