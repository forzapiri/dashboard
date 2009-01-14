<?php
if (!defined('SITE_ROOT')) define('SITE_ROOT', (dirname(__FILE__) . '/../../'));

function rmdir_recurse($path)
{
    $path= rtrim($path, '/').'/';
    $handle = opendir($path);
    for (;false !== ($file = readdir($handle));)
        if($file != "." and $file != ".." and $file != '.gitignore')
        {
            $fullpath= $path.$file;
            if( is_dir($fullpath) )
            {
                rmdir_recurse($fullpath);
                rmdir($fullpath);
            }
            else
              unlink($fullpath);
        }
    closedir($handle);
}

function chmodCacheDirectories() {clearCacheDirectories(false);}

function clearCacheDirectories($rm = true) {
	$dir = scandir(SITE_ROOT . 'cache');
	foreach ($dir as $file) {
		$filename = SITE_ROOT . 'cache/' . $file;
		if (is_dir ($filename) && substr($file,0,1) != '.') { // Doesn't touch .* files
			if ($rm) rmdir_recurse ($filename);
			chmod ($filename, 0777);
		}
	}
}
clearCacheDirectories();


