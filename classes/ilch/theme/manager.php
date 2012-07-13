<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Module manager class
 *
 * @package    Ilch
 * @category   Core/Module
 * @author     Ilch Team
 * @copyright  (c) 2012 Ilch Team
 * @license    http://www.ilch-pluto.net/license
 */
class Ilch_Theme_Manager extends Content_Manager {
	
    public static function get_installed($section)
    {
        $result = Jelly::query('theme')->installed()->select();
        $valid = array();
        
        // Filter invalid themes
        foreach ($result AS $row)
        {
            $path = Theme_Manager::find(Theme_Loader::$paths, $row->name);
            $file = $path.'/views/'.$section.'/index.php';
            
            if (is_file($file))
            {
                $valid[] = array(
                    'path' => $path,
                    'model' => $row
                );
            }
        }
        
        return $valid;
    }
	
}
