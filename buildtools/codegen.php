<?php

error_reporting('E_NONE');

include_once '../include/Site.php';
$smarty->template_dir = 'templates/';

$sql = 'show tables';
$r = Database::singleton()->query_fetch_all($sql);

$db = Database::singleton()->db;

$tables = array();
foreach ($r as $table) {
	$tables[$table['Tables_in_' . $db]] = $table['Tables_in_' . $db];
}

$form = @new Form('table_select');
@$form->addElement('select', 'table', 'Table Name', $tables);
@$form->addElement('submit', 'submit', 'Submit');

$dataDir  = dirname(__FILE__).'/../core/';

$dir  = new DirectoryIterator($dataDir);
$classnames = array(0 => ' -- NONE --');
foreach ($dir as $file) {
	$fileName = $file->getFilename();
	@list($class, $ext) = @explode(".", $fileName);
	if ($ext == 'php') {
		$classnames[$class] = $class;
	}
}

echo '<html>';
echo '<head>';
echo '<title>Norex Code Generator</title>';
echo '<script type="text/javascript" src="/js/prototype.js"></script>';
echo '<script type="text/javascript" src="/js/scriptaculous.js"></script>';
echo '</head>';

echo '<body>';

echo $form->display();

if ($form->validate()) {
	$sql = 'describe ' . $_REQUEST['table'];
	$cols = Database::singleton()->query_fetch_all($sql);

	@$table_form = new Form();
	@$table_form->addElement('hidden', 'table');
	$table_form->setConstants(array('table'=>$_REQUEST['table']));

	@$table_form->addElement('text', 'class_name', 'Class Name');

	foreach ($cols as $col) {
		$group = array();
		$group[] = @$table_form->createElement('text', 'name', 'Name of ' . $col['Field']);
		if ($col['Key'] == "PRI") {
			$priKey = $col['Field'];
		}
		$group[] = @$table_form->createElement('select', 'type', 'Type of ' . $col['Field'], $classnames);
		$table_form->addGroup($group,'cols[' . $col['Field'] . ']','Name of ' . $col['Field'],' ');
	}


	@$table_form->addElement('submit', 'submit', 'Submit');
	echo $table_form->display();

	if ($table_form->validate() && @$_REQUEST['class_name']) {
		$smarty->assign('class', @$_REQUEST['class_name']);

		$cols = array();
		foreach ($_REQUEST['cols'] as $key => $col) {
			$cols[$key] = $col['name'];
		}

		$smarty->assign('cols', @$_REQUEST['cols']);
		$smarty->assign('table', @$_REQUEST['table']);
		$smarty->assign('primary_key', $priKey);

		$php = $smarty->fetch ( 'codegen.tpl' );
		echo '<div style="background-color: #fff; border-left: 2px solid #000; padding-left: 10px; position: absolute; top: 5px; left: 500px;">';
		echo '<h1>Class Code <a href="#" onclick="new Effect.toggle(\'code\'); return false;">[+]</a></h1>';
		$testcode = str_replace(array('<?php', '?>'), '', $php);
		$testcode = str_replace('<', '&lt;', $testcode);
		$testcode = str_replace('>', '&gt;', $testcode);
		echo '<pre id="code">' . $testcode . "</pre>";


		$tmpfname = tempnam("/tmp", "FOO");

		$handle = fopen($tmpfname, "w");
		fwrite($handle, '<?php' . "\n\n" . $smarty->fetch ( 'codegen.tpl' ) . "\n\n" . '?>');

		require_once 'PHPUnit/Util/Skeleton.php';
		$skeleton = new PHPUnit_Util_Skeleton(
		$_REQUEST['class_name'],
		$tmpfname
		);
		echo '<h1>Test Code <a href="#" onclick="new Effect.Appear(\'test\'); return false;">[+]</a></h1>';
		$testcode = str_replace(array('<?php', '?>'), '', $skeleton->generate());
		$testcode = str_replace('<', '&lt;', $testcode);
		$testcode = str_replace('>', '&gt;', $testcode);
		echo '<pre id="test" style="display: none;">' . $testcode . "</pre>";
		echo '</div>';
		var_dump($_REQUEST);
	}
}

echo '</body>';
echo '</html>';

/*
 $sql = 'describe address';
 $r = Database::singleton()->query_fetch_all($sql);
 var_dump($r);


 $smarty->display ( 'codegen.tpl' );
 */
?>