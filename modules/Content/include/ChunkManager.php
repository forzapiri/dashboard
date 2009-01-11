<?php
  /*
   DONE:  Stub data in dbtable, chunk* tables, templates
   NOTE:  modules/Content/chunk.sql has the chunk tables and the dbtable.  LOAD AFTER buildtools/sql/dbtable.sql
   DONE:  Template is parsed, and chunks are filled in
   DONE:  Admin interface presents correct fields
   DONE:  Form fields are populated
   
   TODO:  Update chunks and revisions on save
        - Every save (optional: which changed the block) creates a new revision
		- Every change of the active block redirects all other matching (non-null role + non-null name) pointers
   TODO:  Add "role" -- specified in the template, parsed below in getChunksFromTemplate
   TODO:  Add "name" -- only specifiable NEW fields which have roles; thereafter, readonly
   TODO:  Add select to select those "named" which have a matching role.
   TODO:  A save of a "named" revision updates all Chunks which match both "name" and "role" to point to that revision.
   TODO:  Once working, do an egrep 'CHUNK' to find suggested structural improvements, and move from Content module to core.
   TODO:  Small buttons to go backward and forward in chunk revision history ??
  */
class ChunkManager {
	private $fields = array();
	private $contents = array();
	private $chunks = array();
	private $object = null;

	function __construct($obj) {$this->object = $obj;}
	
	function insertFormFields($form) {
		$this->chunks = Chunk::getAllFor($this->object);
		$i=-1;
		foreach ($this->fields as $field) {
			$i++;
			$el = $field->addElementTo(array ('form' => $form, 'id' => "_chunk_$i"));
			$chunk= @$this->chunks[$i];
			if ($chunk) $el->setValue(DBRow::toForm($chunk->getType(), $chunk->getContent()));
		}
	}

	function saveFormFields($form) {
		$class = get_class($this->object);
		$id = $this->object->getId();
		$i=-1;
		foreach ($this->fields as $field) {
			$i++;
			$chunk = @$this->chunks[$i];
			$type = $field->type();
			$value = $form->exportValue("_chunk_$i");

			if ($chunk) {
				$changed = DBRow::toDB($type, $value) != $chunk->getRawContent();
				$rev = $chunk->getActiveRevision();
			}
			if (!$chunk) {
				$chunk = Chunk::make();
				$chunk->setRevision(999);
				$chunk->save(); // So it has an id
			}
			if (!$chunk || $changed) {
				$prev = $rev;
				$rev = ChunkRevision::make();
				$rev->setParent($chunk->getId());
				$rev->setRevision($changed ? 1+$prev->getRevision() : 0);
				$rev->save(); // So it has an id
				$chunk->setActiveRevisionId($rev->getId());
			}
			$chunk->setType ($field->type()); // TODO: move
			$chunk->setLabel($field->label()); // TODO: move
			$chunk->setParentClass($class);
			$chunk->setParent($id);
			$rev->setContent(DBRow::toDB($field->type(), $value));
			$chunk->save();
			$rev->save();
			/*
			$value = call_user_func (array ($class, 'fromForm'), $value);
			$oldValue = $item['value'];
			$unchanged = call_user_func (array ($class, 'toDB'), $value)
				      == call_user_func (array ($class, 'toDB'), $oldValue);
			if ($unchanged) continue;
			*/
		}
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
