<?php
  /*
   NOTE:  modules/Content/chunk.sql has the chunk tables and the dbtable.  LOAD AFTER buildtools/sql/dbtable.sql

   DONE:  Template is parsed, and chunks are filled in
   DONE:  Admin interface presents correct fields, though no "name" select and edit
   DONE:  Form fields are populated
   
   TODO:  Add select to select those "named" which have a matching role.
             Can select a new text name if the the field has a role (make readonly after named?  I don't think needed.)
			 Be sure to check for name collisions for new names
			 Update the associated text field on change to existing role; popup warns of lost data
   TODO:  Flesh  out stubs in DB which distinguish the active_revision from the draft_revision; then nix the PageContentRevision notion

		  Every page is listed once or twice.  The first listing shows every chunk's active_revision, while
		  if a page has any chunk with a "draft" version, show all draft revisions, with active_revision as fallback.

		  Save a draft (deselect "make live") will save all changed chunks as draft_revisions.

		  To publish a draft (select "make live") for every chunk, move existing draft_revision to active_revision
   TODO:  Update chunks and revisions on save
		- Every change of the active block redirects all other matching (non-null role + non-null name) pointers
   TODO:  A save of a "named" revision updates all Chunks which match both "name" and "role" to point to that revision.
   TODO:  Once working, do a grep 'CHUNK' to find suggested structural improvements, and move from Content module to core.
   TODO:  Small buttons to go backward and forward in chunk revision history ??  dates or version numbers ??
  */

  /*  Group generated styled as:
<li><label class="element">First Column</label>
  <div class="element">
    <select name="__name__[_name_1]">
	   <option value=""></option>
       <option value="__new__">(mark reusable)</option>
    </select>
    &nbsp;&nbsp;&nbsp;
    <input name="__name__[_new_name_1]" type="text" />
  </div>
</li>
<li><label for="_chunk_1" class="element">&nbsp;</label>
  <div class="element">
	<textarea id="_chunk_1" id="_chunk_1" name="_chunk_1" rows="15" cols="16" class="_chunk_1" style="width: 200px">c3</textarea>
    <script type="text/javascript">
	    initRTE("exact","advanced","_chunk_1","/css/style.css","mainContent","tinymce");
	</script></div>
</li>
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
			$label = $field->label();
			if ($this->roles[$i]) {
				$form->addElement('html', "\n<div id=_select_text_$i>");
				$el = array();
				$el[] = $form->createElement('select', "select", "joe", array(''=>'', '__new__'=>'(mark reusable)'));
				$el[] = $form->createElement('text', "text", "larry");
				$form->addGroup($el, "_chunk_name_$i", $label, '&nbsp;&nbsp;&nbsp;');
				$form->addElement('html', "\n</div id=_select_text_$i>");
				$form->addElement('html', "\n<script type='text/javascript'>linkSelectText('_select_text_$i');</script>\n");
				$field->setLabel(""); // Inspect the add edit form, add an appropriate class, use JavaScript to watch for change and update content
			}
			$el = $field->addElementTo(array ('form' => $form, 'id' => "_chunk_$i"));
			$field->setLabel($label);
			if ($chunk = @$this->chunks[$i]) $el->setValue(DBRow::toForm($chunk->getType(), $chunk->getContent()));
		}
		return ++$i; // Returns the number of form fields which were added
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
			if ($chunk->getRole()) {
				$pair = $form->exportValue("_chunk_name_$i");
				switch ($pair['select']) {
				case '__new__': $chunk->setName ($pair['text']);   break;
				case '':        $chunk->setName (null);            break;
				default:       $chunk->setName ($pair['select']); break;
				}
			}
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
