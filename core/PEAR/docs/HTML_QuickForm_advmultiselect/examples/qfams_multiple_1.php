<?php
/**
 * Mixed advMultiSelect HTML_QuickForm elements.
 * Two widgets on the same page/form with each its own javascript function
 *
 * @version    $Id: qfams_multiple_1.php,v 1.4 2008/04/26 17:25:59 farell Exp $
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_QuickForm_advmultiselect
 * @subpackage Examples
 * @access     public
 * @example    examples/qfams_multiple_1.php
 *             qfams_multiple_1 source code
 * @link       http://www.laurent-laville.org/img/qfams/screenshot/multiple1.png
 *             screenshot (Image PNG, 566x392 pixels) 8.82 Kb
 */

require_once 'HTML/QuickForm.php';
require_once 'HTML/QuickForm/advmultiselect.php';

$form = new HTML_QuickForm('amsMultiple1');
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

// rendering with all default options
$form->addElement('header', null, 'Advanced Multiple Select: default layout ');

$ams1 =& $form->addElement('advmultiselect', 'cars', 'Cars:', $car_array);

if (isset($_POST['cars'])) {
    $form->setDefaults(array('cars' => $_POST['cars']));
}

// rendering with css selectors and API selLabel(), setButtonAttributes()
$form->addElement('header', null, 'Advanced Multiple Select: custom layout ');

$ams2 =& $form->addElement('advmultiselect', 'fruit', null, $fruit_array,
                           array('size' => 5,
                                 'class' => 'pool', 'style' => 'width:200px;'
                                )
);
$ams2->setJsElement('fruit_');
$ams2->setLabel(array('Fruit:', 'Available', 'Selected'));
$ams2->setButtonAttributes('add',    array('value' => 'Add', 'name' => 'add1',
                                           'class' => 'inputCommand'
));
$ams2->setButtonAttributes('remove', array('value' => 'Remove', 'name' => 'remove1',
                                           'class' => 'inputCommand'
));

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
<title>HTML_QuickForm::advMultiSelect multiple example 1</title>
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
  width:450px;
}
table.pool th {
  font-size: 80%;
  font-style: italic;
  text-align: left;
}
table.pool select {
  color: white;
  background-color: #006600;
}

.inputCommand {
    background-color: #d0d0d0;
    border: 1px solid #7B7B88;
    width: 7em;
    margin-bottom: 2px;
}
 -->
</style>
<script type="text/javascript">
//<![CDATA[
<?php
echo $ams1->getElementJs();

echo $ams2->getElementJs();
?>
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