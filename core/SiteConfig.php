<?php
/**
 * SiteConfig
 * @author David Wolfe <wolfe@norex.ca>
 * @package CMS
 * @version 1.0
 */

/** 
 * Stores configuration options for a client.
 * 
 * SiteConfig options can be accessed by name (if unique) or by module/name pair.  Each option 
 * can optionally be configurable be the site administrator(s).  If an admin configurable option
 * is multi-valued (a list) then the list should be comma separated for consistency.  
 * @package CMS
 * @subpackage Core
 */

/* SEE ../SiteConfig.php FOR MODULE USAGE INFORMATION */

require_once "SiteConfigType.php";

class SiteConfig {
	/* Columns from db */
	protected $id = null;
	protected $module = null;
	protected $name = null;
	protected $description = null;
	protected $type = null;
	protected $value = null;
	protected $sort = null;
	protected $editable = null;
	private static $programmer;
	private static $cache;

	public static function warnInstall() {
		$query = new Query ("describe `auth`", '');
		$results = $query->fetchAll();
		$u = @$_SESSION['authenticated_user'];
		if ($u && !@$u->column('programmer')) {
			User::logout(false);
			echo "Had to log you out for latest change to take.";
		}
		foreach ($results as $result) {
			if ($result['Field'] == 'programmer') return;
		}
		User::logout(false);
		echo 'Add column programmer to auth.<br/>
  You have been logged out.<br/>
    (1) Rerun auth.sql OR add a column named programmer paralleling the status column.<br/>
    (2) Make the norex User a programmer.';
		die();
	}

	public static function emulating() {
		if (!self::programmer(true)) return false;
		if (self::programmer()) return "Programmer";
		$u = $_SESSION['authenticated_user'];
		$group = Group::make($u->getGroup());
		return $group->getName();
	}

	public static function programmer($truth = false) {
		if (!isset(self::$programmer)) {
			if (!isset($_SESSION['programmerView']))
				$_SESSION['programmerView'] = 'Programmer';
			$u = @$_SESSION['authenticated_user'];
			if (!$u) return false;
			self::$programmer = $u->getProgrammer();			
			if ($p = @$_REQUEST['programmerEmulating']) {
				$t = Group::getAll("where name=?", "s", $p=='Programmer' ? 'Administrator' : $p);
				if ($t) {
					$u->setGroup($t[0]->getId());
					$u->save();
					$_SESSION['authenticated_user'] = $u;
				}
				$_SESSION['programmerView'] = $p;
			}
		}
		return self::$programmer && ($truth || $_SESSION['programmerView'] == 'Programmer');
	}

	private static function load() {
		if (isset(self::$cache)) return;
		self::$cache = array();
		$sql = 'select * from config_options';
		if (!$results = Database::singleton()->query_fetch_all($sql)) {
			return;
		}
		foreach ($results as $result) {
			$config = new SiteConfig();
			$config->setId($result['id']);
			$config->setModule($result['module']);
			$config->setName($result['name']);
			$config->setDescription($result['description']);
			$config->setType($result['type']);
			$config->setValue($result['value']);
			$config->setSort($result['sort']);
			$config->setEditable($result['editable']);
			self::$cache[$result['id']] = $config;
		}

	}
	

	static function make($id = null) {
		self::load();
		if ($id) return self::$cache[$id];
		else return new SiteConfig();
	}
	
		
	
	private function __construct( $id = null ) {
		self::load();
		if ($id) {
			error_log ('Should not be here');
		}
		$this->setModule(NULL);
		$this->setName('');
		$this->setDescription('');
		$this->setType('string');
		$this->setValue('');
		$this->setSort(NULL);
		$this->setEditable(0);
	}
	
	public function getType() {
		return SiteConfigType::getType($this);
	}

	/**
	 * The raw type name, without the specification in the case of enum.
	 */
	
	public function getTypeName() {
		preg_match('/^[a-z]+/', $this->getRawType(), $matches);
		return $matches[0];
	}
	
	public function displayString() {
		return SiteConfigType::getDisplayString($this);		
	}
	
	public function getValue() {
		return SiteConfigType::getValue($this);
	}
	
	private static function locate($name) {
		self::load();
		if (preg_match ('/(.*)::(.*)/', $name, $matches)) {
			$module = $matches[1];
			$name = $matches[2];
		} else {
			$module = "";
		}
		foreach (self::$cache as $config) {
			if ($config->getModule() == $module && $config->getName() == $name) {
				return $config;
			}
		}
		return new SiteConfig();
	}
	
	public static function get($name) {
		$siteConfig = SiteConfig::locate ($name);
		return $siteConfig->getValue();
	}

	public static function set($name, $value) {
		$siteConfig = SiteConfig::locate ($name);
		SiteConfigType::setValue($siteConfig, $value);
		$siteConfig->save();
	}

	public function getId() {return $this->id;}
	public function getModule() {return $this->module;}

	public function getName($qualified = false) {
		if ($qualified && $this->module)
			return $this->module . '::' . $this->name;
			else return $this->name;
	}
	
	public function getDescription() {return $this->description;}
	public function getRawType() {
		return $this->type;
	}

	public function getRawValue() {
		return $this->value;
	}

	public function getSort() {return $this->sort;}
	public function getEditable() {return $this->editable;}
	public function setId( $id ) {$this->id = $id;}

	public function setModule( $module ) {
		if (!$module) $module = NULL;
		$this->module = $module;
	}

	public function setName( $name ) {$this->name = $name;}
	public function setDescription( $description ) {$this->description = $description;}
	public function setType( $type ) {$this->type = $type;}
	public function setValue( $value ) {$this->value = $value;}
	public function setSort( $sort ) {$this->sort = $sort;}
	public function setEditable( $editable ) {$this->editable = $editable;}

	private function sql ($column, $value) {
		return is_null ($value) ? '' : '`' . $column . '`="' . e($value) . '", ';
	}
	public function save() {
		if (!is_null($this->getId())) {
			$sql = 'update config_options set ';
		} else {
			$sql = 'insert into config_options set ';
		}
		$m = $this->getModule();
		$sql .= '`module`=' . ($m ? '"' . e($m) . '"' : 'NULL') . ', ';
		$sql .= $this->sql('name', $this->getName());
		$sql .= $this->sql('description', $this->getDescription());
		$sql .= $this->sql('type', $this->getRawType());
		$sql .= $this->sql('value', $this->getRawValue());
		$sql .= $this->sql('sort', $this->getSort());
		$sql .= $this->sql('editable', $this->getEditable());
		$sql = trim($sql, ', ');
		if (!is_null($this->getId())) {
			$sql .= ' where id="' . e($this->getId()) . '"';
		}
		Database::singleton()->query($sql);
		if (is_null($this->getId())) {
			$this->setId(Database::singleton()->lastInsertedID());
			self::$cache[$this->getId()] = $this;
		}
	}

	public function delete() {
		$sql = 'delete from config_options where id="' . e($this->getId()) . '"';
		Database::singleton()->query($sql);
	}

	public function getAddEditForm($target = '/admin/SiteConfig') {
		$form = new Form('SiteConfig_addedit', 'post', $target);
		$programmer = self::programmer();
		
		$form->setConstants( array ( 'action' => 'addedit') );
		$form->addElement( 'hidden', 'action' );
		
		if (!is_null($this->getId())) {
			$form->setConstants( array ( 'siteconfig_id' => $this->getId() ) );
			$form->addElement( 'hidden', 'siteconfig_id' );
			// $defaultValues ['siteconfig_value'] = $this->getRawValue();
			// $form->setDefaults( $defaultValues );
		} else {
			if (!$programmer) {
				error_log ("Attempt was made to create a new config option.");
				die();
			}
		}
		if (!$programmer) {
			$form->addElement('html', 'siteconfig_description', 'Description')->setValue($this->getDescription());
			SiteConfigType::setFormField($form, $this);
		} else {
			$form->addElement('html', 'Types are: ' . SiteConfigType::getTypeList() . '.<br/>An example of enum is "enum(yes, no, maybe)".'		);
			$form->addElement('text', 'siteconfig_module', 'Module')->setValue($this->getModule());
			$form->addElement('text', 'siteconfig_name', 'Name')->setValue($this->getName());
			$form->addElement('text', 'siteconfig_description', 'Description', array('size' => 40))->setValue($this->getDescription());
			$form->addElement('text', 'siteconfig_type', 'Type')->setValue($this->getRawType());
			$form->addElement('text', 'siteconfig_sort', 'Sort')->setValue($this->getSort());
			SiteConfigType::setFormField($form, $this);
		}
		$form->getElement('siteconfig_value')->setValue(SiteConfigType::getDisplayString($this));
		$form->addElement('submit', 'siteconfig_submit', 'Submit');
		if ($form->validate() && $form->isSubmitted() && isset($_REQUEST['siteconfig_submit'])) {
			if ($programmer) {
				$this->setModule($form->exportValue('siteconfig_module'));
				$this->setName($form->exportValue('siteconfig_name'));
				$this->setDescription($form->exportValue('siteconfig_description'));
				$this->setType($form->exportValue('siteconfig_type'));
				$this->setSort($form->exportValue('siteconfig_sort'));
			}
			$this->setValue(SiteConfigType::getFormValue($form, $this));
			$this->save();
		}
		return $form;
		
	}

	public static function getAll() {
		$sql = 'select * from config_options ' . (self::programmer() ? '' : 'where editable="1" ') . 'order by module, sort, name';
		$results = Database::singleton()->query_fetch_all($sql);
		foreach ($results as &$result) {
		        $result = self::$cache[$result['id']];
		}
		if (!method_exists ('Config', 'getActiveModules')) return $results;

		$modules = Config::getActiveModules();
		foreach ($modules as &$module) $module = $module['module'];
		$modules[] = '';
		$modules = array_flip($modules);

		foreach ($results as &$result) {
			if (array_key_exists ($result->getModule(), $modules)) $configs[] = $result;
		}
		return $configs; 
	}
}
