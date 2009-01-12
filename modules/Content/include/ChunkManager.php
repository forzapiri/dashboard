<?php
  /*
   NOTE:  modules/Content/chunk.sql has the chunk tables and the dbtable.  LOAD AFTER buildtools/sql/dbtable.sql

   DONE:  Template is parsed, and chunks are filled in
   DONE:  Admin interface presents correct fields
   DONE:  Form fields are populated
   
   TODO:  Flesh  out stubs in DB which distinguish the active_revision from the draft_revision; the nix the ContentRevision notion
   TODO:  Update chunks and revisions on save
		- Every change of the active block redirects all other matching (non-null role + non-null name) pointers
   TODO:  Add "name" -- for NEW fields which have roles; thereafter, readonly
   TODO:  Add select to select those "named" which have a matching role.
   TODO:  A save of a "named" revision updates all Chunks which match both "name" and "role" to point to that revision.
   TODO:  Once working, do a grep 'CHUNK' to find suggested structural improvements, and move from Content module to core.
   TODO:  Small buttons to go backward and forward in chunk revision history ??
  */
class ChunkManager {
	private $fields = array();
	private $roles = array();
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
				$newRevision = DBRow::toDB($type, $value) != $chunk->getRawContent();
				$rev = $chunk->getActiveRevision();
			} else {
				$newRevision = true;
				$chunk = Chunk::make();
				$chunk->save(); // So it has an id
				$rev = null;
			}
			if ($newRevision) {
				$prev = $rev;
				$rev = ChunkRevision::make();
				$rev->setParent($chunk->getId());
				$rev->setRevision($prev ? 1+$prev->getRevision() : 0);
				$rev->save(); // So it has an id
				$chunk->setActiveRevisionId($rev->getId());
			}
			$chunk->setRole ($this->roles[$i]);
			$chunk->setType ($field->type()); // TODO: move
			$chunk->setLabel($field->label()); // TODO: move
			$chunk->setParentClass($class);
			$chunk->setParent($id);
			$rev->setContent(DBRow::toDB($field->type(), $value));
			$chunk->save();
			$rev->save();
		}
	}
	
	function setTemplate($template) {
		if (!$template) return array();
		if (is_object ($template)) $template = $template->getData();
		$titlechars = '[^"\']';
		$argchars = '[^"\']';
		if (!preg_match_all('/{\$chunks->get\("([^":]*):([^"]*)"\)}/',
							$template,
							$matches,
							PREG_SET_ORDER)) return array();
		foreach ($matches as $req) {
			$label = $req[1];
			$args = split(',', trim($req[2]));
			$role = null;
			$type = null;
			foreach ($args as $arg) {
				$pair = split(':', trim($arg));
				$var = $pair[0];
				if (in_array ($var, array ("type", "role")))
					$$var = $pair[1];
				else trigger_error ("Variable $var not recognized in ChunkManager::setTemplate()");
			}
			$this->fields[] = DBColumn::make($type, '', $label);
			$this->roles[] = $role;
		}
	}
}
