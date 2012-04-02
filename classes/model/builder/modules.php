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
class Model_Builder_Modules extends Jelly_Builder
{
    public function active()
	{
		return $this->where('activated', '=', TRUE);
	}
	
	public function order($sorting = 'ASC')
	{
		return $this->order_by('position', $sorting);
	}
}