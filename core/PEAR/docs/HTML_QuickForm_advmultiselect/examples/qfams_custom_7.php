<?php
/**
 * Custom advMultiSelect HTML_QuickForm element
 * with extended buttons (select all, select none, toggle selection)
 *
 * @version    $Id: qfams_custom_7.php,v 1.3 2008/04/26 13:25:44 farell Exp $
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_QuickForm_advmultiselect
 * @subpackage Examples
 * @access     public
 * @example    examples/qfams_custom_7.php
 *             qfams_custom_7 source code
 * @link       http://www.laurent-laville.org/img/qfams/screenshot/custom7.png
 *             screenshot (Image PNG, 640x525 pixels) 160 Kb
 */

require_once 'HTML/QuickForm.php';
require_once 'HTML/QuickForm/advmultiselect.php';

$form = new HTML_QuickForm('amsCustom7');
$form->removeAttribute('name');        // XHTML compliance

$fruit_array = array(
    'apple'     =>  'Apple',
    'orange'    =>  'Orange',
    'pear'      =>  'Pear',
    'banana'    =>  'Banana',
    'cherry'    =>  'Cherry',
    'kiwi'      =>  'Kiwi',
    'lemon'     =>  'Lemon',
    'lime'      =>  'Lime',
    'tangerine' =>  'Tangerine',
);


// rendering with QF renderer engine and template system
$form->addElement('header', null, 'Advanced Multiple Select: custom layout ');

$ams =& $form->addElement('advmultiselect', 'fruit', null, $fruit_array,
                           array('class' => 'pool', 'style' => 'width:200px;')
);
$ams->setLabel(array('Fruit:', 'Available', 'Selected'));

$ams->setButtonAttributes('add'     , 'class=inputCommand');
$ams->setButtonAttributes('remove'  , 'class=inputCommand');
$ams->setButtonAttributes('all'     , 'class=inputCommand');
$ams->setButtonAttributes('none'    , 'class=inputCommand');
$ams->setButtonAttributes('toggle'  , 'class=inputCommand');
$ams->setButtonAttributes('moveup'  , 'class=inputCommand');
$ams->setButtonAttributes('movedown', 'class=inputCommand');

// template for a single checkboxes multi-select element shape
$template1 = '
<table{class}>
<!-- BEGIN label_3 --><tr><th>{label_3}</th><th>&nbsp;</th></tr><!-- END label_3 -->
<tr>
  <td>{selected}</td>
  <td>{all}<br />{none}<br />{toggle}</td>
</tr>
</table>
';

// template for a dual multi-select element shape
$template2 = '
<table{class}>
<!-- BEGIN label_2 --><tr><th>{label_2}</th><!-- END label_2 -->
<!-- BEGIN label_3 --><th>&nbsp;</th><th>{label_3}</th></tr><!-- END label_3 -->
<tr>
  <td>{unselected}</td>
  <td align="center">
    {add}<br />{remove}<br /><br />{all}<br />{none}<br /><br />{moveup}<br />{movedown}<br />
  </td>
  <td>{selected}</td>
</tr>
</table>
';

if (isset($_POST['multiselect'])) {
    $ams->setElementTemplate($template2);
} else {
    $ams->setElementTemplate($template1);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // fruit default values already selected without any end-user actions
    $form->setDefaults(array('fruit' => array('kiwi','lime')));

} elseif (isset($_POST['fruit'])) {
    // fruit end-user selection
    $form->setDefaults(array('fruit' => $_POST['fruit']));
}

$buttons[] =& $form->createElement('submit', null, 'Submit');
$buttons[] =& $form->createElement('reset',  null, 'Reset');
$buttons[] =& $form->createElement('checkbox', 'multiselect', null,
                                   'use dual select boxes layout');
$form->addGroup($buttons, null, '&nbsp;');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>HTML_QuickForm::advMultiSelect custom example 7</title>
<style type="text/css">
<!--
body {
  background-color: #FFF;
  font-family: Verdana, Arial, helvetica;
  font-size: 10pt;
}

table.pool {
  border: 0;
  background-color: cyan;
}
table.pool td {
  padding-left: 1em;
}
table.pool th {
  font-size: 80%;
  font-style: italic;
  text-align: center;
}
table.pool select {
  color: gray;
  background-color: #eee;
}

.inputCommand {
  width: 120px;
}
<?php
if (!isset($_POST['multiselect'])) {
    echo $ams->getElementCss();
}
?>
 -->
</style>
<?php echo $ams->getElementJs(false); ?>
</head>
<body>
<?php
if ($form->validate()) {
    $clean = $form->getSubmitValues();

    echo '<pre>';
    print_r($clean);
    echo '</pre>';
}
$form->display();
?>
</body>
</html>