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

include_once 'Auth/Auth.php';
include_once 'Auth/Container.php';

class CMSAuthContainer extends Auth_Container
{
	
	private $username;
	private $password;
	
    /**
     * Constructor
     */
    function CMSAuthContainer() {}

    /**
     * Check to see if the submitted info is valid.
     * 
     * Overload the standard container class to check to see if the submitted credentials represent
     * a valid authentication token.
     *
     * @param string $username
     * @param string $password
     * @return bool true if valid, false otherwise
     */
    function fetchData($username, $password) {
    	$sql = "SELECT * FROM auth WHERE username = '". e($username) ."' AND status = 1";
        $token = Database::singleton()->query_fetch($sql);
        if ((md5($password . md5($token['salt']))) == $token['password']) {
        	$_SESSION['authenticated_user'] = User::make($token['id']);    
        	return true;
        } else {
        	unset($_SESSION['authenticated_user']);
        	return false;
        }
    	
    }
    
    public static function getAuthLevels() {
    	$sql = "SELECT * FROM auth_groups";
    	$result = Database::singleton()->query_fetch_all($sql);
    	
    	$level = array();
    	foreach ($result as $row) {
    		$levels[$row['id']] = $row['name'];
    	}

    	return $levels;
    }
    
}
