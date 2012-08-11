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
class Model_Builder_Theme extends Jelly_Builder
{
    public function installed()
	{
	    // Build query extension
		$this->where('installed', '=', TRUE);
        
        // Run event
        Event::run('Classes_Model_Builder_Theme::installed::after', $this);
        
        return $this;
	}
}