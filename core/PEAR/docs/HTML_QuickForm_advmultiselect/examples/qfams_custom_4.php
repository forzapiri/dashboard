<?php
/**
 * Custom advMultiSelect HTML_QuickForm element
 * that present alternatively a dual multsi-select
 * or a single checkboxes with fancy attributes.
 *
 * @version    $Id: qfams_custom_4.php,v 1.6 2008/04/26 12:45:44 farell Exp $
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_QuickForm_advmultiselect
 * @subpackage Examples
 * @access     public
 * @example    examples/qfams_custom_4.php
 *             qfams_custom_4 source code
 * @link       http://www.laurent-laville.org/img/qfams/screenshot/custom4.png
 *             screenshot (Image PNG, 419x317 pixels) 6.02 Kb
 */

require_once 'HTML/QuickForm.php';
require_once 'HTML/QuickForm/advmultiselect.php';

$form = new HTML_QuickForm('amsCustom4');
$form->removeAttribute('name');        // XHTML compliance

$fruit_styles = array(
    'class' => 'icons',
    'onmouseover' => "this.className='over'",
    'onmouseout'  => "this.className='icons'"
);
$pear  = array_merge($fruit_styles, array('disabled' => 'disabled'));
$lemon = array_merge($fruit_styles,
                     array('class' => 'goldstar',
                           'onmouseout'  => "this.className='goldstar'"
));
$tangerine = array_merge($fruit_styles,
                         array('class' => 'bluestar',
                               'onmouseout'  => "this.className='bluestar'",
                               'style' => 'color:red;')
);

$fruit_array = array(
    'apple'     =>  'Apple',
    'orange'    =>  'Orange',
    'pear'      =>  array('Pear', $pear),
    'banana'    =>  'Banana',
    'cherry'    =>  'Cherry',
    'kiwi'      =>  'Kiwi',
    'lemon'     =>  array('Lemon', $lemon),
    'lime'      =>  'Lime',
    'tangerine' =>  array('Tangerine', $tangerine),
);

// rendering with QF renderer engine and template system
$form->addElement('header', null, 'Advanced Multiple Select: custom layout ');

$form->addElement('text', 'name', 'Name:', array('size' => 40, 'maxlength' => 80));

$ams =& $form->addElement('advmultiselect', 'fruit', null, null,
                           array('class' => 'pool')
);
foreach ($fruit_array as $key => $data) {
    if (!is_array($data)) {
        $data = array($data, $fruit_styles);
    }
    $attr = isset($data[1]) ? $data[1] : null;
    $ams->addOption($data[0], $key, $attr);
}

$ams->setLabel(array('Fruit:', 'Available', 'Selected'));

// template for a dual multi-select element shape
$template2 = '
<table{class}>
<!-- BEGIN label_2 --><tr><th>{label_2}</th><!-- END label_2 -->
<!-- BEGIN label_3 --><th>&nbsp;</th><th>{label_3}</th></tr><!-- END label_3 -->
<tr>
  <td>{unselected}</td>
  <td align="center">{add}{remove}</td>
  <td>{selected}</td>
</tr>
</table>
';

// template for a single checkboxes multi-select element shape
$template1 = '
<table{class}>
<!-- BEGIN label_3 --><tr><th>{label_3}</th></tr><!-- END label_3 -->
<tr>
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
$buttons[] =& $form->createElement('reset', null, 'Reset');
$buttons[] =& $form->createElement('checkbox', 'multiselect', null,
                                   'use dual select boxes layout');
$form->addGroup($buttons, null, '&nbsp;');

$form->addRule('name', 'Your name is required', 'required');
$form->addGroupRule('fruit', 'At least one fruit is required', 'required', null, 1);

$form->applyFilter('__ALL__', 'trim');
$form->applyFilter('__ALL__', 'strip_tags');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>HTML_QuickForm::advMultiSelect custom example 4</title>
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

<?php
if (!isset($_POST['multiselect'])) {
    echo $ams->getElementCss();

    echo '
label input {
  margin-right: 16px;
}
label.bluestar, label.goldstar {
  background-repeat: no-repeat;
  background-position: 20px center;
}
label.bluestar{
  background-image: url(bluestar-12.gif) ;
}
label.goldstar {
  background-image: url(goldstar-12.gif) ;
}

label.over {
  background-color: #0a246a;
  color: #fff;
}
';
}
?>

 -->
</style>
<?php
if (isset($_POST['multiselect'])) {
    echo $ams->getElementJs(false);
}
?>
</head>
<body>
<?php
if ($form->validate()) {
    $clean = $form->getSubmitValues();

    echo '<pre>';
    print_r($clean);
    echo '</pre>';

    printf("<p>Welcome <b>%s</b> you've selected these fruits:</p>",
           $clean['name']);
    echo '<p>' . implode(', ', $clean['fruit']) . '</p>';
}
$form->display();
?>
</body>
</html>