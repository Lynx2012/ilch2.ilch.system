<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Query builder for "theme" table
 *
 * @package    Ilch/Core
 * @category   Modules
 * @author     Ilch Team
 * @copyright  (c) 2012 Ilch Team
 * @license    http://www.ilch-pluto.net/license
 */
class Ilch_Model_Builder_Theme extends Jelly_Builder
{
    public function installed()
	{
	    // Build query extension
		$query = $this->where('installed', '=', TRUE);
        
        // Run event
        Event::run('Model_Builder_Theme::installed::after', $this);
        
        return $query;
	}
}