<?php
class Chunk extends DBRow {
	function createTable() {return parent::createTable("chunk", __CLASS__);}
	static function getAll($where = null) {return self::$tables[__CLASS__]->getAllRows($where);}
	static function make($id = null) {return parent::make($id, __CLASS__);}

	private $field;
	function setField($field) {$this->field = $field;}
	function getField() {return $this->field;}

	static function getFormFields($form, $types) {
		$col = DBColumn::make('text', 'description', 'Description');
		$col->addElementTo(array('form' => $form, 'id' => 'test_me', 'ljka'));
	}

	static function getAllFor($obj) {
		$class = get_class($obj);
		$id = $obj->getId();
		$results = $this->getAll("where class=$class and parent=$id order by sort");
	}
  }
DBRow::init('Chunk');
?>
