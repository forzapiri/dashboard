<?php
/**
 * Database
 * @package CMS
 * @author Christopher Troup <chris@norex.ca>
 * @version 2.0
 */

/**
 * Database connection, querying functions.
 *
 * This object employs a singleton method, so to instatiate the database
 * object use something like:
 * $db = Database::singleton();
 *
 * Class _should_ be serialize-safe so you can store it in a session variable
 * to keep a persistant connection.
 * @package CMS
 * @subpackage Core
 */
class Database {

	/**
	 * A reference to an already instantiated Database object
	 *
	 * @var ref
	 */
	private static $instance;

	/**
	 * Database link
	 *
	 * @var MySQLi Object
	 */
	public $link;

	public $queries_run = 0;
	public $sql_run = array();

	/**
	 * Connection information.
	 */
	private $server, $username, $password;
	public $db;

	/**
	 * Construct the Database object
	 *
	 * Load the configuration variables from the db-config.php file and connect to the database server.
	 *
	 */
	private function __construct() {

		/**
		 * include the database configuration file. Contains username, password, etc.
		 */
		include_once (dirname(__FILE__) . '/../include/db-config.php');
		//include(SITE_ROOT.'/include/db-config.php');
		if (!(@$dbhost && @$dbuser && @$dbpass && @$dbase)) {
			printf ("<h1>Check that db-config.php is installed properly.</h1>");
			die();
		}
		$this->server = $dbhost;
		$this->username = $dbuser;
		$this->password = $dbpass;
		$this->db = $dbase;

		// connect
		$this->connect();
	}

	/**
	 * Singleton method to ensure that there is only ever one connection to the database, and
	 * all queries are piped through it.
	 *
	 * @return ref
	 */
	public static function singleton() {
		if (! isset(self::$instance)) {
			$c = __CLASS__;
			self::$instance = new $c();
		}

		return self::$instance;
	}

	/**
	 * Connect to the database
	 */
	private function connect() {
		$this->link = mysqli_connect($this->server, $this->username, $this->password);
		mysqli_select_db($this->link, $this->db);
	}

	/**
	 * Perform a query on the database
	 * Commented out code represents a debugging hack to use MySQL describe to check for query optimization.
	 *
	 * @param string $sql
	 * @return Query
	 */
	public function query($sql) {
		/*  THIS DEBUGGING CODE IS PROBLEMATIC IF THE QUERY SHOULD ONLY BE EXECUTED ONCE...
		if (@DEBUG) {
			require_once('Debug.php');
			$describe = 'describe ' . $sql;
			$result = @mysqli_query($this->link, $sql);
			if ($result == null) $result = @mysqli_query($this->link, $sql);
			$m = var_export(@$this->fetch_all($result), true);
			Debug::singleton()->addMessage($sql, $m, 'sql');
		}
		*/
		$result = mysqli_query($this->link, $sql);
		if (!$result) {
			$error = $this->link->error;
			printf("MySQL Error:  Check php error log");
			error_log("MySQL Error: $error: $sql") ;
			die();
		}
		return $result;
	}
	
	public function multi_query($sql) {
		if (mysqli_multi_query($this->link, $sql)) {
		    do {
		        /* store first result set */
		        if ($result = mysqli_store_result($this->link)) {
		            while ($row = mysqli_fetch_row($result)) {
		            }
		            mysqli_free_result($result);
		        }
		        /* print divider */
		        if (mysqli_more_results($this->link)) {
		        }
		    } while (mysqli_next_result($this->link));
		    return true;
		}
		return false;
	}

	/**
	 * Preform a fetch on the passed query object.
	 *
	 * @param Query $result
	 * @return array
	 */
	public function fetch($result) {
		return mysqli_fetch_assoc($result);
	}

	/**
	 * Fetches all queried results
	 *
	 * @param Query $result
	 * @return array
	 */
	public function fetch_all($result) {
		$result_set = array();
		while ($row = $this->fetch($result)) {
			$result_set[] = $row;
		}
		return $result_set;
	}

	/**
	 * Performs query and fetches all results
	 *
	 * @param string $sql
	 * @return array
	 */
	public function query_fetch_all($sql) {
		$result = $this->query($sql);
		return $this->fetch_all($result);
	}

	/**
	 * Performs query and fetches first result
	 *
	 * @param string $sql
	 * @return array
	 */
	public function query_fetch($sql) {
		$result = $this->query($sql);
		return $this->fetch($result);
	}

	/**
	 * Get ID of last inserted row
	 *
	 * @return int
	 */
	public function lastInsertedID() {
		return mysqli_insert_id($this->link);
	}

	/**
	 * Escapes a string headed for the database using the DB link
	 * */
	public function escape($input) {
		$sanitized = mysqli_real_escape_string ($this->link, $input);
		return $sanitized;
	}

	/**
	 *
	 * Returns a string to it's unescaped form by stripping slashes and rebuilding newlines.
	 * Can be passed a multidimensional array or a simple datatype.
	 * Doesn't require the mysql link var but wanted to keep it with it's opposite function.
	 */
	public function unescape($output) {
		if (is_array($output)) {
			array_walk_recursive($output, create_function('&$v, $k', '$v = stripslashes($v);'));
		}
		else {
			$output = stripslashes($output);
		}
		return $output;
	}

	/**
	 * If the object is about to be serialized, store the information nessasary to reconnect
	 * after unserializing
	 */
	public function __sleep() {
		return array('server', 'username', 'password', 'db', 'link');
		//return $this;
	}

	/**
	 * Automagically re-connect to DB immediatly after unserializing.
	 */
	public function __wakeup() {
	}

	/**
	 * Prevent users to clone the instance. There only ever needs to be one DB connection at a time.
	 */
	public function __clone() {
		trigger_error('Clone is not allowed.', E_USER_ERROR);
	}

	public function __destruct() {
		@mysqli_close($this->link);
		unset($this);
	}
}
