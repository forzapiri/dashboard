/**
 * {$class}
 * @author Christopher Troup <chris@norex.ca>
 * @package CMS
 * @version 2.0
 */

/**
 * DETAILED CLASS TITLE
 * 
 * DETAILED DESCRIPTION OF THE CLASS
 * @package CMS
 * @subpackage Core
 */
class {$class} {literal}{{/literal}

{foreach from=$cols item=col key=key}
	/**
	 * Variable associated with `{$key}` column in table.
	 *
	 * @var string
	 */
	protected ${$col.name|default:$key} = null;
	
{/foreach}
	/**
	 * Create an instance of the {$class} class.
	 * 
	 * This takes the primary key as a parameter and builds the object around the
	 * returned row. If the parameter is null, not specified or the row does not
	 * exist then a blank template {$class} object is returned.
	 *
	 * @param int ${$primary_key}
	 * @return {$class} object
	 */
	public function __construct( ${$primary_key} = null ) {literal}{{/literal}
		if (!is_null(${$primary_key})) {literal}{{/literal}
			$sql = 'select * from {$table} where {$primary_key}=' . ${$primary_key};
			if (!$result = Database::singleton()->query_fetch($sql)) {literal}{{/literal}
				return false;
			{literal}}{/literal}

{foreach from=$cols item=col key=key}
			$this->set{$col.name|default:$key|capitalize}($result['{$key}']);
{/foreach}
		{literal}}{/literal}
	{literal}}{/literal}

{foreach from=$cols item=col key=key}
	/**
	 * Returns the object's {$col.name|default:$key|capitalize}
	 *
	 * @return string
	 */
	public function get{$col.name|default:$key|capitalize}() {literal}{{/literal}
		return $this->{$col.name|default:$key};
	{literal}}{/literal}

{/foreach}
{foreach from=$cols item=col key=key}
	/**
	 * Sets the object's {$col.name|default:$key|capitalize}
	 *
	 * @param string ${$col.name|default:$key} New $this->{$col.name|default:$key} value
	 */
	public function set{$col.name|default:$key|capitalize}( ${$col.name|default:$key} ) {literal}{{/literal}
		$this->{$col.name|default:$key} = {if $col.type == '0'}${$col.name|default:$key}{else}new {$col.type}(${$col.name|default:$key}){/if};
	{literal}}{/literal}

{/foreach}

	/**
	 * Save the object in the database
	 */
	public function save(&$notification) {literal}{{/literal}
		$object = &$notification->getNotificationObject();
		if (!is_null($object->get{$cols.$primary_key.name|capitalize}())) {literal}{{/literal}
			$sql = 'update {$table} set ';
		{literal}}{/literal} else {literal}{{/literal}
			$sql = 'insert into {$table} set ';
		{literal}}{/literal}
{foreach from=$cols item=col key=key}
{if $key != $primary_key}
		if (!is_null($object->get{$col.name|default:$key|capitalize}())) {literal}{{/literal}
			$sql .= '`{$key}`="' . e($object->get{$col.name|default:$key|capitalize}(){if $col.type != '0'}->getId(){/if}) . '", ';
		{literal}}{/literal}
{/if}
{/foreach}
		if (!is_null($object->get{$cols.$primary_key.name|capitalize}())) {literal}{{/literal}
			$sql .= '{$primary_key}="' . e($object->get{$cols.$primary_key.name|capitalize}()) . '" where {$primary_key}="' . e($object->get{$cols.$primary_key.name|capitalize}()) . '"';
		{literal}}{/literal} else {literal}{{/literal}
			$sql = trim($sql, ', ');
		{literal}}{/literal}
		Database::singleton()->query($sql);
		if (is_null($object->get{$cols.$primary_key.name|capitalize}())) {literal}{{/literal}
			$object->set{$cols.$primary_key.name|capitalize}(Database::singleton()->lastInsertedID());
			$object->__construct($object->get{$cols.$primary_key.name|capitalize}());
		{literal}}{/literal}
	{literal}}{/literal}

	/**
	 * Delete the object from the database
	 */
	public function delete(&$notification) {literal}{{/literal}
		$object = &$notification->getNotificationObject();
		$sql = 'delete from {$table} where {$primary_key}="' . e($object->get{$cols.$primary_key.name|capitalize}()) . '"';
		Database::singleton()->query($sql);
	{literal}}{/literal}

	/**
	 * Get an Add/Edit form for the object.
	 *
	 * @param string $target Post target for form submission
	 */
	public function getAddEditForm($target = '/admin/{$class}') {literal}{{/literal}
		$form = new Form('{$class}_addedit', 'post', $target);
		
		$form->setConstants( array ( 'action' => 'addedit' ) );
		$form->addElement( 'hidden', 'action' );
		
		if (!is_null($this->get{$cols.$primary_key.name|capitalize}())) {literal}{{/literal}
			$form->setConstants( array ( '{$class|lower}_{$primary_key}' => $this->get{$cols.$primary_key.name|capitalize}() ) );
			$form->addElement( 'hidden', '{$class|lower}_{$primary_key}' );
			
{foreach from=$cols item=col key=key}
{if $key != $primary_key}
			$defaultValues ['{$class|lower}_{$col.name|default:$key}'] = $this->get{$col.name|default:$key|capitalize}(){if $col.type != '0'}->getId(){/if};
{/if}
{/foreach}

			$form->setDefaults( $defaultValues );
		{literal}}{/literal}
					
{foreach from=$cols item=col key=key}
{if $key != $primary_key}
		$form->addElement('text', '{$class|lower}_{$col.name|default:$key}', '{$col.name|default:$key}');
{/if}
{/foreach}
		$form->addElement('submit', '{$class|lower}_submit', 'Submit');

		if ($form->validate() && $form->isSubmitted()) {literal}{{/literal}
{foreach from=$cols item=col key=key}
{if $key != $primary_key}
			$this->set{$col.name|default:$key|capitalize}($form->exportValue('{$class|lower}_{$col.name|default:$key}'));
{/if}
{/foreach}
			$notification = &Event_Dispatcher::getInstance('{$class}')->post($this, 'onSave');
		{literal}}{/literal}

		return $form;
		
	{literal}}{/literal}
	
	/**
	 * Return an array of all existing objects of this type in the database
	 */
	public static function getAll{$class|capitalize}s() {literal}{{/literal}
		$sql = 'select `{$cols.name.$primary_key|default:$primary_key}` from {$table}';
		$results = Database::singleton()->query_fetch_all($sql);
		
		foreach ($results as &$result) {literal}{{/literal}
			$result = new {$class|capitalize}($result['{$cols.name.$primary_key|default:$primary_key}']);
		{literal}}{/literal}
		
		return $results;
	{literal}}{/literal}
	
{literal}}{/literal}
