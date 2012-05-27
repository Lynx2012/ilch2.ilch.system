<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Transparent extension of the Ilch_Dir class
 *
 * @package    Ilch
 * @category   Core
 * @author     Ilch Team
 * @copyright  (c) 2012 Ilch Team
 * @license    http://www.ilch-pluto.net/license
 */
class Ilch_Dir {
    
    /**
     * Delete directory content
     */
    public static function clear($path)
    {
        // Parse path
        $path = realpath($path).DS;
        
        // Check directory
        if (!is_dir($path)) return FALSE;
        
        // Open directory
        $dir = opendir($path);
        
        while (($file = readdir($dir)) !== false)
        {
            // Invalid directories
            if (in_array($file, array('.', '..'))) continue;

            // Remove this directory recrusive
            if (is_dir($path.$file))
            {
                Dir::remove($path.$file);
            }
            // Delete this file
            elseif (is_file($path.$file))
            {
                unlink($path.$file);
            }
        }
        closedir($dir);
    }
    
    /**
     * Delete directory and content
     */
    public static function remove($path)
    {
        Dir::clear($path);
        return rmdir($path);
    }
    
}
