<?php
/**
 *  This file is part of Dashboard.
 *
 *  Dashboard is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Dashboard is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Dashboard.  If not, see <http://www.gnu.org/licenses/>.
 *  
 *  @license http://www.gnu.org/licenses/gpl.txt
 *  @copyright Copyright 2007-2009 Norex Core Web Development
 *  @author See CREDITS file
 *
 */

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
	$dir = scandir(SITE_ROOT . '/cache');
	foreach ($dir as $file) {
		$filename = SITE_ROOT . '/cache/' . $file;
		if (is_dir ($filename) && substr($file,0,1) != '.') { // Doesn't touch .* files
			if ($rm) rmdir_recurse ($filename);
			@chmod ($filename, 0777);
		}
	}
}
clearCacheDirectories();


