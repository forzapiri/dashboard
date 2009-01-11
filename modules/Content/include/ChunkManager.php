<?php
  /*
   DONE:  Stub data in dbtable, chunk* tables, templates
   NOTE:  modules/Content/chunk.sql has the chunk tables and the dbtable.  LOAD AFTER buildtools/sql/dbtable.sql
   DONE:  Template is parsed, and chunks are filled in
   DONE:  Admin interface presents correct fields
   DONE:  Form fields are populated
   
   TODO:  Update chunks and revisions on save
        - Every save creates a new revision
   TODO:  Add "role" -- specified in the template, parsed below in getChunksFromTemplate
   TODO:  Add "name" -- only specifiable NEW fields which have roles; thereafter, readonly
   TODO:  Add select to select those "named" which have a matching role.
   TODO:  A save of a "named" revision updates all Chunks which match both "name" and "role" to point to that revision.
   TODO:  Once working, do an egrep 'CHUNK' to find suggested structural improvements, and move from Content module to core. 
  */
class ChunkManager {
	private $fields = array();
	private $content = array();
	private $object = null;

	function __construct($obj) {$this->object = $obj;}
	
	function insertFormFields($form) {
		$this->content = ChunkRevision::getAllContentFor($this->object, false);
		$i=-1;
		foreach ($this->fields as $field) {
			$i++;
			$el = $field->addElementTo(array ('form' => $form, 'id' => "_chunk_$i"));
			$item= @$this->content[$i]; // A value, DBColumn-class pair
			if (!$item) continue;
			$value = call_user_func (array ($item['class'], 'toForm'), $item['value']);
			$el->setValue($value);
		}
	}

	function saveFormFields($form) {
		$class = get_class($this->object);
		$id = $this->object->getId();
		$i=0;
		/* CENTRALIZE AND LOAD 
		foreach ($this->fields as $field) {
			$i++;
			$chunk = $rel->getChunk($class, $id, $i);
			$chunk->setType($field->type());
			$chunk->setLabel($field->label());
			if ($chunk->getRevisionId())
				$rev = $chunk->getChunkRevision();
			else
				$rev = ChunkRevision::make();
			if ($chunk->get
		}
		*/
	}
	
	function setTemplate($template) {
		if (!$template) return array();
		if (is_object ($template)) $template = $template->getData();
		if (!preg_match_all('/{\*\h*CHUNK\h*([^:*]*):\h*([a-z]*)\h*\*}/',
							$template,
							$matches,
							PREG_SET_ORDER)) return array();
		foreach ($matches as $req) {
			$label = $req[1];
			$type = $req[2];
			$results[] = DBColumn::make($type, '', $label);
		}
		$this->fields = $results;
	}
}
