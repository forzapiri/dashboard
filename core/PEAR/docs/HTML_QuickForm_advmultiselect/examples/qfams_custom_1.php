<?php
/**
 * Custom advMultiSelect HTML_QuickForm element
 * using stylesheet rules selectors and a template.
 *
 * The template allows to add label as headers of dual select box
 * and moves the button to another location (below each select box).
 *
 * @version    $Id: qfams_custom_1.php,v 1.4 2008/04/26 17:25:59 farell Exp $
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_QuickForm_advmultiselect
 * @subpackage Examples
 * @access     public
 * @example    examples/qfams_custom_1.php
 *             qfams_custom_1 source code
 * @link       http://www.laurent-laville.org/img/qfams/screenshot/custom1.png
 *             screenshot (Image PNG, 677x197 pixels) 4.80 Kb
 */

require_once 'HTML/QuickForm.php';
require_once 'HTML/QuickForm/advmultiselect.php';

$form = new HTML_QuickForm('amsCustom1');
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
$renderer->setElementTemplate($withoutLabel, 'send');

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
                           array('size' => 5,
                                 'class' => 'pool', 'style' => 'width:300px;'
                                )
);
$ams->setLabel(array('Fruit:', 'Available', 'Selected'));
$ams->setButtonAttributes('add',    array('value' => 'Add >>',
                                           'class' => 'inputCommand'
));
$ams->setButtonAttributes('remove', array('value' => '<< Remove',
                                           'class' => 'inputCommand'
));
$template = '
<table{class}>
<!-- BEGIN label_2 --><tr><th align="center">{label_2}</th><!-- END label_2 -->
<!-- BEGIN label_3 --><th align="center">{label_3}</th></tr><!-- END label_3 -->
<tr>
  <td>{unselected}</td>
  <td>{selected}</td>
</tr>
<tr>
  <td align="center">{add}</td>
  <td align="center">{remove}</td>
</tr>
</table>';
$ams->setElementTemplate($template);

if (isset($_POST['fruit'])) {
    $form->setDefaults(array('fruit' => $_POST['fruit']));
}

$form->addElement('submit', 'send', 'Send');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>HTML_QuickForm::advMultiSelect custom example 1</title>
<style type="text/css">
<!--
body {
  background-color: #FFF;
  font-family: Verdana, Arial, helvetica;
  font-size: 10pt;
}

table.pool {
  border: 0;
  background-color: lightyellow;
}
table.pool th {
  font-size: 80%;
  font-style: italic;
  text-align: center;
}
table.pool select {
  background-color: lightblue;
}

.inputCommand {
    background-color: #d0d0d0;
    border: 1px solid #7B7B88;
    width: 7em;
    margin-bottom: 2px;
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