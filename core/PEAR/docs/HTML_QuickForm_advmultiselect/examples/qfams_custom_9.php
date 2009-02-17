<?php
/**
 * Custom advMultiSelect HTML_QuickForm element in single or dual shape
 * with fancy attributes items and all buttons
 *
 * @version    $Id: qfams_custom_9.php,v 1.4 2009/02/08 21:51:20 farell Exp $
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_QuickForm_advmultiselect
 * @subpackage Examples
 * @access     public
 * @example    examples/qfams_custom_9.php
 *             qfams_custom_9 source code
 * @link       http://www.laurent-laville.org/img/qfams/screenshot/custom9.png
 *             screenshot (Image PNG, 640x620 pixels) 33.3 Kb
 */

require_once 'HTML/QuickForm.php';
require_once 'HTML/QuickForm/advmultiselect.php';

$form = new HTML_QuickForm('amsCustom9');
$form->removeAttribute('name');        // XHTML compliance

$fruit_array = array(
    'apple'     =>  'Apple',
    'orange'    =>  'Orange',
    'pear'      =>  array('Pear', array('disabled' => 'disabled')),
    'banana'    =>  'Banana',
    'cherry'    =>  'Cherry',
    'kiwi'      =>  array('Kiwi', array('style' => 'color:green;background-color:lightblue')),
    'lemon'     =>  array('Lemon', array('style' => 'color:yellow;background-color:black')),
    'lime'      =>  array('Lime', array('style' => 'color:blue')),
    'tangerine' =>  array('Tangerine', array('disabled' => 'disabled',
                                             'style' => 'color:red;'))
);

// rendering with QF renderer engine and template system
$form->addElement('header', null, 'Advanced Multiple Select: custom layout ');

$ams =& $form->createElement('advmultiselect', 'fruit', null, null,
                             array('class' => 'pool', 'style' => 'width:200px;')
);
$ams->setLabel(array('Fruit:', 'Available', 'Selected'));

$ams->setButtonAttributes('add'       , 'class=inputCommand');
$ams->setButtonAttributes('remove'    , 'class=inputCommand');
$ams->setButtonAttributes('all'       , 'class=inputCommand');
$ams->setButtonAttributes('none'      , 'class=inputCommand');
$ams->setButtonAttributes('toggle'    , 'class=inputCommand');
$ams->setButtonAttributes('moveup'    , 'class=inputCommand');
$ams->setButtonAttributes('movedown'  , 'class=inputCommand');
$ams->setButtonAttributes('movetop'   , 'class=inputCommand');
$ams->setButtonAttributes('movebottom', 'class=inputCommand');

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
    {add}<br />{remove}<br /><br />
    {all}<br />{none}<br />{toggle}<br /><br />
    {moveup}<br />{movedown}<br />{movetop}<br />{movebottom}
  </td>
  <td>{selected}</td>
</tr>
</table>
';

$ams->load($fruit_array, 'pear,kiwi,lime');

$ams->setPersistantOptions(array('pear', 'tangerine'));

if (isset($_POST['multiselect']) || $_SERVER['REQUEST_METHOD'] == 'GET') {
    $ams->setElementTemplate($template2);
} else {
    $ams->setElementTemplate($template1);
}

$form->addElement($ams);

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
<title>HTML_QuickForm::advMultiSelect custom example 9</title>
<style type="text/css">
<!--
body {
  background-color: #FFF;
  font-family: Verdana, Arial, helvetica;
  font-size: 10pt;
}

table.pool {
  border: 0;
  background-color: #787878;
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
  color: #242424;
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
<script type="text/javascript">
//<![CDATA[
var QFAMS = {};
QFAMS.env = {persistantSelection: false, persistantMove: false};

<?php echo $ams->getElementJs(true); ?>
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

    // if apple fruit is selected, then pear may be remove from next selection
    if (in_array('apple', $clean['fruit'])) {
        $ams->setPersistantOptions('pear', false);
    } else {
        $ams->setPersistantOptions('pear', true);
        $selection = $ams->getSelected();
        if (!in_array('pear', $selection)) {
            array_push($selection, 'pear');
            $ams->setSelected($selection);
        }
    }
}
$form->display();
?>
</body>
</html>