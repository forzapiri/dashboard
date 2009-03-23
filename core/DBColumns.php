<?php
/*
 * Suggested naming convention for new types:
 * lowerCaseCamel is a raw type, while UpperCaseCamel is a reference to an object.
 * So 'image' is a blob, while 'Image' is an id for an Image object.
 */

class DBColumnText extends DBColumn {
	function type() {return "text";}
	function addElementTo ($args) {return parent::addElementTo($args);}
}

class DBFileUpload extends DBColumn {
	function type() { return 'file'; }
	function addElementTo($args) {
		$value = '';
		extract($args);
        $label = $this->label() . ($value ? " (currently $value)": "");
		$el = $form->addElement ('file', $id, $label);
		return $el;
	}
	static function fromForm($obj, $el = null) {
		if ($el->isUploadedFile()) {
			$image = File::make();
			$image->insert($_FILES[$el->getName()]);
			$image->setPublic();
			$image->save();
			return $image;
		}
	}
	static function fromDB($obj) {return File::make($obj);}
	static function toDB($obj) {return $obj ? $obj->getId() : null;}
    static function toForm($obj) {return $obj->getFilename();}
	function suggestedMysql() {return "int(11)";}
}

class DBImage extends DBFileUpload {
	function type() { return 'image'; }
}

class DBColumnPassword extends DBColumn {
	function type() {return "password";}
	function addElementTo ($args) {
		$value = '';
		$label = $this->label();
		extract($args);
		$el = $form->addElement ('password', $id, $label);
		$el->setValue($value);
		return $el;
	}
}

class DBColumnTextArea extends DBColumn {
	function type() {return "textarea";}
	function addElementTo ($args) {
		$value = '';
		$label = $this->label();
		extract($args);
		$options = $this->options();
		if ((count($options) == 2)
			&& is_string(@$options[0]) && (@$options[0] > 0)
			&& is_string(@$options[1]) && (@$options[1] > 0))
		{
			$options = array ('rows' => $options[0], 'cols' => $options[1]);
		} else if (!$options) {
			$options = array ('rows' => 10, 'cols' => 50);
		}
		$el = $form->addElement ('textarea', $id, $label, $options);
		$el->setValue($value);
		return $el;
	}
}
class DBColumnTextBox extends DBColumnTextArea {function type() {return "textbox";}} // Synonym for textarea

class DBColumnString extends DBColumn {
	function type() {return "string";}
	function suggestedMysql() {return "varchar(255)";}
}


class DBColumnTinytext extends DBColumn {
	function type() {return "tinytext";}
	function suggestedMysql() {return "tinytext";}
}

class DBColumnsLongText extends DBColumnTextArea {
	function type() {return 'longtext';}
	function prepareCode() {return 's';} // TODO: NOT SURE YET "b" or "s" ??
	function delayLoad() {return true;}
	function suggestedMysql() {return "longtext";}
}

class DBColumnInteger extends DBColumn {
	function type() {return 'integer';}
	function prepareCode() {return 'i';}
	function addElementTo ($args) {
		$value = 0;
		$label = $this->label();
		extract($args);
		$el = $form->addElement ('text', $id, $label);
		$el->setValue($value);
		$form->addRule($id, 'Integer required', 'integer', null, 'client');
		return $el;
	}
	function suggestedMysql() {return "int(11)";}
}

class DBColumnFloat extends DBColumnText {
	function type() {return 'float';}
	function prepareCode() {return 'd';}
	static function toDB($obj){
		return number_format($obj, 2, ".", "");
	}
	static function fromDB($obj){
		return number_format($obj, 2, ".", "");
	}
	function suggestedMysql() {return "float(11,2)";}
}

class DBColumnSort extends DBColumnInteger {
	function type() {return 'sort';}
	function __toString($item, $key) {
		return '<img src="/images/admin/drag_handle.png" />';
	}
}


class DBColumnEmail extends DBColumnText {
	function type() {return "email";}
	function addElementTo ($args) {
		parent::addElementTo($args);
		extract($args);
		$form->addRule($id, 'Please enter a valid e-mail address', 'email', null, 'client');
	}
	function suggestedMysql() {return "tinytext";}
	function __toString($item, $key) {
		return '<a href="mailto:' . $item->get($key) . '">' . $item->get($key) . '</a>';
	}
}

class DBColumnMoney extends DBColumnText {
	function type() {return "money";}
	function suggestedMysql() {return "tinytext";}
	function addElementTo ($args) {
		parent::addElementTo($args);
		extract($args);
		$form->addRule($id, 'Please enter a valid number (ex: 55.00)', 'numeric', null, 'client');
		$form->addRule($id, 'Please enter an amount', 'required', null, 'client');
	}
	
	public function __toString($item, $key) {
		return sprintf("$%01.2f", $item->get($key));
	}
}

class DBColumnStatus extends DBColumnCheckbox {
	function type() {return "status";}
	public function __toString($item, $key) {
		$html = '<form action="/admin/' . $_REQUEST['module'] . '" method="post" onsubmit="return !ui.formSubmit(this);" style="float: left;">
					<input type="hidden" name="section" value="' . get_class($item) . '" />
					<input type="hidden" name="action" value="toggle" />
					<input type="hidden" name="' . $item->quickformPrefix() . 'id" value="' . $item->get('id') . '" />';
		if (isset($_REQUEST['pageID'])) $html .= '<input type="hidden" name="pageID" value="' . $_REQUEST['pageID'] . '" />';
		if ($item->get($key)) {
			$html .= '<input type="image" src="/images/admin/tick.png" />';
		} else {
			$html .= '<input type="image" src="/images/admin/cross.png" />';
		}
		$html .=  '</form>';
		return $html;
	}
}

class DBColumnCheckbox extends DBColumnInteger {
	function type() {return "checkbox";}
	function addElementTo ($args) {
		$value = 0;
		$label = $this->label();
		extract($args);
		$el = $form->addElement ('checkbox', $id, $label);
		$el->setValue($value);
		return $el;
	}
	static function toDB($obj) {return $obj ? 1 : 0;}
	static function fromDB($obj) {return !!$obj;}
	
	static function toForm($obj) {return $obj ? 1 : 0;}
	// checkboxes appear to return '1' (checked) or true (not checked) !!
	static function fromForm($obj) {return '1' === $obj;}
	function suggestedMysql() {return "tinyint(1)";}
}

class DBColumnFeatured extends DBColumnCheckbox {
	function type() {return "featured";}
	static function toDB($obj, $el) {
		if ($obj) {
			$os = $el->getAll("where featured=1 limit 1", '');
			foreach ($os as $o) {
				$o->setFeatured(0);
				$o->save();
			}
		}
		return parent::toDB($obj);
	}
}

class DBColumnId extends DBColumnInteger {
	function type() {return "id";}
	function addElementTo($args) {
		$value = null;
		extract ($args);
		$el = $form->addElement ('hidden', $id);
		$el->setValue($value);
		return $el;
	}
	function suggestedMysql() {return "int(10) unsigned";}
}

class DBColumnTinyMCE extends DBColumnsLongText {
	function type() {return "tinymce";}
	function addElementTo($args) {
		$value = null;
		extract ($args);
		$label = $this->label();
		$el = $form->addElement ('tinymce', $id, $label);
		$el->setValue($value);
		return $el;
	}
	function suggestedMysql() {return "text";}
}

class DBColumnSelect extends DBColumnText {
	function type() {return "select";}
	
	function addElementTo($args) {
		$value = null;
		$label = $this->label();
		extract ($args);
		$options = $this->options();
 		switch (count($options)) {
		/*case 0: break;
		case 1:
			$value = array_keys($options);
			$value = $value[0];
			$el = $form->addElement ('hidden', $id);
			break;*/
		default:
			$el = $form->addElement ('select', $id, $label, $options);
			break;
		}
		$el->setValue($value);
		return $el;
	}
	function suggestedMysql() {return "tinytext";}
}

class DBColumnTimestamp extends DBColumnText {
	function type() {return "timestamp";}
	static function toDB($obj) {$date = is_object($obj) ? $obj : new NDate($obj); return $date->get(MYSQL_TIMESTAMP);}
	static function fromDB($obj) {return new NDate($obj);}
	static function toForm($obj) {return self::toDB($obj);}
	static function fromForm($obj) {return self::fromDB($obj);}
	function addElementTo ($args) {
		$value = null;
		extract ($args);
		$el = $form->addElement ('hidden', $id);
		$el->setValue($value);
		return $el;
	}
	function suggestedMysql() {return "timestamp";}
}

class DBColumnDate extends DBColumnTimestamp {
	function type() {return "date";}
	static function toDB($obj) {$date = is_object($obj) ? $obj : new NDate($obj); return $date->get(MYSQL_TIMESTAMP);}
	function addElementTo ($args) {
		$value = self::toDB(new NDate());
		$label = $this->label();
		extract ($args);
		$date = new NDate($value);
		$date_options = array(
			'language' => 'en',
			'format' => 'M d Y',
			'maxYear' => $date->get('%Y')+5,
			'minYear' => $date->get('%Y')-2);
		$el = $form->addElement('date', $id, $label, array_merge($date_options, $this->options()));
		$el->setValue($value);
		return $el;
	}
	function suggestedMysql() {return "date";}
}

class DBColumnDateTime extends DBColumnTimestamp {
	function type() {return "datetime";}
	function addElementTo ($args) {
		$value = null;
		extract ($args);
		$label = $this->label();
		$el = $form->addElement ('date', $id, $label, array('format'=>'d-M-Y H:i:s'));
		$el->setValue($value);
		return $el;
	}
	function suggestedMysql() {return "datetime";}
}

class DBColumnEnum extends DBColumnSelect {
	function __construct($name=null, $label=null, $modifier=null, $options=null) {
		parent::__construct ($name, $label, $modifier, $options ? array_combine ($options, $options) : array());
	}
	function type() {return "enum";}
	function suggestedMysql() {return "enum('" . implode("','", $this->options()) . "')";}
}

class DBColumnHTML extends DBColumnText {
	function type() {return "html";}
	function ignored() {return true;}
	function addElementTo ($args) {
		$value = null;
		extract ($args);
		return $form->addElement ('html', $value);
	}
	function suggestedMysql() {return "";}
}

class DBColumnLatLon extends DBColumnText {
function type() {return "latlon";}
public function __toString($item,$key) {
		return '<a href="http://maps.google.ca/maps?f=q&hl=en&geocode=&q=' . urlencode($item->get($key)) . '">' . $item->get($key) . '</a>';
	}
}

class DBColumnCancel extends DBColumn {
	function type() {return "cancel";}	
	function ignored() {return true;}
	function addElementTo($args) {
		extract ($args);
		return $form->addElement('button','cancel','Cancel',array("onClick"=> "window.location.href='Monthly.php'"));
	}
}

class DBColumnURL extends DBColumnText {
	function type() {return 'url';}
	function addElementTo ($args) {
		$label = $this->label();
		extract($args);
		if (!@$value) $value = "http://";
		$el = $form->addElement ('text', $id, $label, array('size'=>'80'));
		$el->setValue($value);
		$chars = "a-z0-9_"; // Legal chars in the url
		$form->addRule($id, 'URL required, e.g., http://www.norex.ca', 'regex', "!http(s)?://[$chars]+!", 'client');
		return $el;
	}
}

class DBColumnCode extends DBColumn{
	function type() {return 'code';}	
	function addElementTo($args) {
		$value = null;
		extract ($args);
		$label = $this->label();
		$el = $form->addElement ('textarea', $id, $label, array('rows' => 15, 'cols' => 70));
		$el->setValue($value);
		return $el;
	}
}

class DBCaptcha extends DBColumn {
	function type() {return 'captcha';}
	function ignored() {return true;}
	function addElementTo($args) {
		require_once(SITE_ROOT . '/core/captchalib/securimage.php');
		$value = null;
		extract ($args);
		$label = $this->label();
		$el = $form->addElement ('captcha', $id, $label);
		$form->addRule($id, 'CAPTCHA Required', 'required', "", 'client');
		
		$captcha = new Securimage();
		
		$form->registerRule('checkcaptcha', 'callback', 'check', $captcha);
		$form->addRule($id, 'CAPTCHA is incorrect', 'checkcaptcha');
		
		$el->setValue($value);
		return $el;
	}
}
/* ----------------------------- PUT NEW CLASSES ABOVE THIS LINE! ---------------------- */
DBColumn::registerClasses();
/* ------------------------------------------------------------------------------------- */
