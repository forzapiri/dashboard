<?php
/**
 * Custom advMultiSelect HTML_QuickForm element
 * that allows to manage sort of select boxes.
 *
 * @version    $Id: qfams_custom_5.php,v 1.5 2008/04/26 17:25:59 farell Exp $
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_QuickForm_advmultiselect
 * @subpackage Examples
 * @access     public
 * @example    examples/qfams_custom_5.php
 *             qfams_custom_5 source code
 * @link       http://www.laurent-laville.org/img/qfams/screenshot/custom5.png
 *             screenshot (Image PNG, 609x318 pixels) 9.94 Kb
 */

require_once 'HTML/QuickForm.php';
require_once 'HTML/QuickForm/advmultiselect.php';

$form = new HTML_QuickForm('amsCustom5');
$form->removeAttribute('name');        // XHTML compliance

// same as default element template but wihtout the label (in first td cell)
$withoutLabel = <<<_HTML
<tr valign="top">
    <td align="right">
        &nbsp;
    </td>
    <td align="left">
        <!-- BEGIN error --><span style="color: #ff0000;">{error}</span><br /><!-- END error -->{element}
    </td>
</tr>
_HTML;

// more XHTML compliant
// replace default element template with label, because submit button have no label
$renderer =& $form->defaultRenderer();
$renderer->setElementTemplate($withoutLabel, 'validate');

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

// decides either both select list will have their elements be arranged or not
if (isset($_POST['autoArrange'])) {
    if ($_POST['autoArrange'] == 'A') {
        $sort = SORT_ASC;
    } elseif ($_POST['autoArrange'] == 'D') {
        $sort = SORT_DESC;
    } else {
        $sort = false;
    }
} else {
    $sort = false;
}

// rendering with QF renderer engine and template system
$form->addElement('header', null,
                  'For demo purpose only: must be validate to be active');
$arrange[] =& $form->createElement('radio', null, null, 'Auto arrange asc.',  'A');
$arrange[] =& $form->createElement('radio', null, null, 'Auto arrange desc.', 'D');
$arrange[] =& $form->createElement('radio', null, null, 'No auto arrange',    'N');
$form->addGroup($arrange, 'autoArrange', 'Sort list:');
$form->setDefaults(array('autoArrange' => 'N'));

$form->addElement('submit', 'validate', 'Validate');

$form->addElement('header', null, 'Advanced Multiple Select: custom layout ');

$ams =& $form->addElement('advmultiselect', 'fruit', null, $fruit_array,
                           array('class' => 'pool', 'style' => 'width:200px;'),
                           $sort
);
$ams->setLabel(array('Fruit:', 'Available', 'Selected'));

$ams->setButtonAttributes('add'     , 'class=inputCommand');
$ams->setButtonAttributes('remove'  , 'class=inputCommand');
$ams->setButtonAttributes('moveup'  , 'class=inputCommand');
$ams->setButtonAttributes('movedown', 'class=inputCommand');

// template for a dual multi-select element shape
$template = '
<table{class}>
<!-- BEGIN label_2 --><tr><th>{label_2}</th><!-- END label_2 -->
<!-- BEGIN label_3 --><th>&nbsp;</th><th>{label_3}</th></tr><!-- END label_3 -->
<tr>
  <td>{unselected}</td>
  <td align="center">
    {add}<br />{remove}<br /><br />{moveup}<br />{movedown}<br />
  </td>
  <td>{selected}</td>
</tr>
</table>
';
$ams->setElementTemplate($template);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // fruit default values already selected without any end-user actions
    $form->setDefaults(array('fruit' => array('kiwi','lime')));

} elseif (isset($_POST['fruit'])) {
    // fruit end-user selection
    $form->setDefaults(array('fruit' => $_POST['fruit']));
}

$buttons[] =& $form->createElement('submit', null, 'Submit');
$buttons[] =& $form->createElement('reset',  null, 'Reset');
$form->addGroup($buttons, null, '&nbsp;');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>HTML_QuickForm::advMultiSelect custom example 5</title>
<style type="text/css">
<!--
body {
  background-color: #FFF;
  font-family: Verdana, Arial, helvetica;
  font-size: 10pt;
}

table.pool {
  border: 0;
  background-color: #339900;
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
  color: white;
  background-color: #006600;
}

.inputCommand {
  width: 60px;
}
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