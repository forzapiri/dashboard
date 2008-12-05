<?php
/**
 * Two advMultiSelect HTML_QuickForm elements with all properties
 * that can be display in one or two select box mode.
 * This example demonstrate the new feature of version 1.3.0 : Live Counter
 *
 * @version    $Id: qfams_multiple_2.php,v 1.2 2008/04/26 13:25:14 farell Exp $
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_QuickForm_advmultiselect
 * @subpackage Examples
 * @access     public
 * @example    examples/qfams_multiple_2.php
 *             qfams_multiple_2 source code
 * @link       http://www.laurent-laville.org/img/qfams/screenshot/multiple2.png
 *             screenshot (Image PNG, 595x511 pixels) 11.9 Kb
 */

require_once 'HTML/QuickForm.php';
require_once 'HTML/QuickForm/advmultiselect.php';

$form = new HTML_QuickForm('amsMultiple2');
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

$car_array = array(
    'dodge'     =>  'Dodge',
    'chevy'     =>  'Chevy',
    'bmw'       =>  'BMW',
    'audi'      =>  'Audi',
    'porsche'   =>  'Porsche',
    'kia'       =>  'Kia',
    'subaru'    =>  'Subaru',
    'mazda'     =>  'Mazda',
    'isuzu'     =>  'Isuzu',
);

// template for a single checkboxes multi-select element shape with live counter
$template1 = '
<table{class}>
<!-- BEGIN label_3 --><tr><th>{label_3}(<span id="{selected_count_id}">{selected_count}</span>)</th><th>&nbsp;</th></tr><!-- END label_3 -->
<tr>
  <td>{selected}</td>
  <td>{all}<br />{none}<br />{toggle}</td>
</tr>
</table>
';

// template for a dual multi-select element shape with live counter
$template2 = '
<table{class}>
<!-- BEGIN label_2 --><tr><th>{label_2}(<span id="{unselected_count_id}">{unselected_count}</span>)</th><!-- END label_2 -->
<!-- BEGIN label_3 --><th>&nbsp;</th><th>{label_3}(<span id="{selected_count_id}">{selected_count}</span>)</th></tr><!-- END label_3 -->
<tr>
  <td>{unselected}</td>
  <td align="center">
    {add}<br />{remove}<br /><br />{all}<br />{none}<br />{toggle}<br /><br />{moveup}<br />{movedown}<br />
  </td>
  <td>{selected}</td>
</tr>
</table>
';

$defaults = array();

// first QF ams element
$form->addElement('header', null, 'Advanced Multiple Select: Live Counter - pool1 style ');

$ams1 =& $form->addElement('advmultiselect', 'cars', null, $car_array,
    array('size' => 10, 'class' => 'pool1', 'style' => 'width:200px;')
);
$ams1->setLabel(array('Cars:', 'Available', 'Selected'));
$ams1->setButtonAttributes('add',      array('name' => 'add1',      'class' => 'inputCommand'));
$ams1->setButtonAttributes('remove',   array('name' => 'remove1',   'class' => 'inputCommand'));
$ams1->setButtonAttributes('all',      array('name' => 'all1',      'class' => 'inputCommand'));
$ams1->setButtonAttributes('none',     array('name' => 'none1',     'class' => 'inputCommand'));
$ams1->setButtonAttributes('toggle',   array('name' => 'toggle1',   'class' => 'inputCommand'));
$ams1->setButtonAttributes('moveup',   array('name' => 'moveup1',   'class' => 'inputCommand'));
$ams1->setButtonAttributes('movedown', array('name' => 'movedown1', 'class' => 'inputCommand'));

if (isset($_POST['multiselect1'])) {
    $ams1->setElementTemplate($template2);
} else {
    $ams1->setElementTemplate($template1);
}

if (isset($_POST['cars'])) {
    $defaults = array('cars' => $_POST['cars']);
}

// second QF ams element
$form->addElement('header', null, 'Advanced Multiple Select: Live Counter - pool2 style ');

$ams2 =& $form->addElement('advmultiselect', 'fruit', null, $fruit_array,
    array('size' => 5, 'class' => 'pool2', 'style' => 'width:300px;')
);
$ams2->setLabel(array('Fruit:', 'Available', 'Selected'));
$ams2->setButtonAttributes('add',      array('name' => 'add2',      'class' => 'inputCommand'));
$ams2->setButtonAttributes('remove',   array('name' => 'remove2',   'class' => 'inputCommand'));
$ams2->setButtonAttributes('all',      array('name' => 'all2',      'class' => 'inputCommand'));
$ams2->setButtonAttributes('none',     array('name' => 'none2',     'class' => 'inputCommand'));
$ams2->setButtonAttributes('toggle',   array('name' => 'toggle2',   'class' => 'inputCommand'));
$ams2->setButtonAttributes('moveup',   array('name' => 'moveup2',   'class' => 'inputCommand'));
$ams2->setButtonAttributes('movedown', array('name' => 'movedown2', 'class' => 'inputCommand'));

if (isset($_POST['multiselect2'])) {
    $ams2->setElementTemplate($template2);
} else {
    $ams2->setElementTemplate($template1);
}

if (isset($_POST['fruit'])) {
    $defaults = array_merge($defaults, array('fruit' => $_POST['fruit']));
}

$buttons[] =& $form->createElement('submit', null, 'Submit');
$buttons[] =& $form->createElement('reset',  null, 'Reset');
$buttons[] =& $form->createElement('checkbox', 'multiselect1', null,
                                   'cars list dual select');
$buttons[] =& $form->createElement('checkbox', 'multiselect2', null,
                                   'fruit list dual select');
$form->addGroup($buttons, null, '&nbsp;');

if (count($defaults) > 0) {
    $form->setDefaults($defaults);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>HTML_QuickForm::advMultiSelect multiple example 2</title>
<style type="text/css">
<!--
body {
  background-color: #FFF;
  font-family: Verdana, Arial, helvetica;
  font-size: 10pt;
}

table.pool1, table.pool2 {
  border: 0;
  background-color: #339900;
  width:450px;
}
table.pool2 {
  background-color: #CFC;
}
table.pool1 th, table.pool2 th {
  font-size: 80%;
  font-style: italic;
  text-align: left;
}
table.pool1 td, table.pool2 td {
  vertical-align: top;
}
table.pool1 select, table.pool2 select {
  color: white;
  background-color: #006600;
}

.inputCommand {
    background-color: #d0d0d0;
    border: 1px solid white;
    width: 9em;
    margin-bottom: 2px;
}
<?php
if (!isset($_POST['multiselect1'])) {
    echo $ams1->getElementCss();
}
if (!isset($_POST['multiselect2'])) {
    echo $ams2->getElementCss();
}
?>
 -->
</style>
<?php echo $ams1->getElementJs(false); ?>
<script type="text/javascript">
//<![CDATA[
window.qfamsName = new Array();
window.qfamsName[0] = 'cars';
window.qfamsName[1] = 'fruit';
window.addEventListener('load', qfamsInit, false);
//]]>
</script>
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