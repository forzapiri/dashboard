<?php

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

?>