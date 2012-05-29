<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Query builder for "modules" table
 *
 * @package    Ilch/Core
 * @category   Modules
 * @author     Ilch Team
 * @copyright  (c) 2012 Ilch Team
 * @license    http://www.ilch-pluto.net/license
 */
class Ilch_Model_Builder_Module extends Jelly_Builder
{
    public function active()
	{
	    // Build query extension
		$query = $this->where('activated', '=', TRUE);
        
        // Run event
        Event::run('Model_Builder_Module::active::after', $this);
        
        return $query;
	}
	
	public function order($sorting = 'ASC')
	{
        // Build query extension
        $query = $this->order_by('position', $sorting);
        
        // Run event
        Event::run('Model_Builder_Module::order::after', $this);
        
        return $query;
	}
}