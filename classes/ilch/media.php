<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Media class
 */
class Ilch_Media {
	
	/*
	 * Get file informations as array
     * @param string file path
     * @return array
	 */
	public static function get($file)
	{
	    // Find the file extension
	    $ext = pathinfo($file, PATHINFO_EXTENSION);
        
	    // Create data collector
	    $data = array(
            'name' => $file,
            'ext' => $ext,
            'clear' => substr($file, 0, -(strlen($ext) + 1)),
            'body' => NULL,
            'type' => NULL,
            'modified' => NULL
        );
        
        // Run event
        Event::run('Ilch_Media::get::before', $data);
        
        // Content is empty
        if ($data['body'] === NULL)
        {
    		if ($file = Kohana::find_file('media', $data['clear'], $data['ext']))
    		{
    			$data['body'] = file_get_contents($file);
                $data['type'] = File::mime_by_ext($data['ext']);
                $data['modified'] = filemtime($file);
    		}
        }
        
        // Run event
        Event::run('Ilch_Media::get::after', $data);
        
        return $data;
	}
	
	/*
	 * Return static file with document header and body
	 */
	public static function controller(Request $request, Response $response, $file)
	{
	    $data = Media::get($file);
        
		if ($data['body'] !== NULL)
		{
			// Check if the browser sent an "if-none-match: <etag>" header, and tell if the file hasn't changed
			$response->check_cache(sha1($request->uri()).$data['modified'], $request);

			// Send the file content as the response
			$response->body($data['body']);

			// Set the proper headers to allow caching
			$response->headers('content-type',  $data['type']);
			$response->headers('last-modified', date('r', $data['modified']));
		}
		else
		{
			// Return a 404 status
			$response->status(404);
		}
        
        // Run event
        Event::run('Ilch_Media::controller::after', $request);
	}
    
    public static function path($file, $protocol = NULL, $index = TRUE)
    {
		if (strpos($file, '://') === FALSE)
		{
			// Add the base URL
			$file = URL::base($protocol, $index).'media/'.$file;
		}
        
        return $file;
    }
	
}