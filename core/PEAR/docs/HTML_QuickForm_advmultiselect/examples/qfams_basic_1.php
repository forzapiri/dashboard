<?php
/**
 * Basic advMultiSelect HTML_QuickForm element
 * without any customization.
 *
 * @version    $Id: qfams_basic_1.php,v 1.4 2008/04/26 17:25:59 farell Exp $
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_QuickForm_advmultiselect
 * @subpackage Examples
 * @access     public
 * @example    examples/qfams_basic_1.php
 *             qfams_basic_1 source code
 * @link       http://www.laurent-laville.org/img/qfams/screenshot/basic1.png
 *             screenshot (Image PNG, 406x247 pixels) 4.95 Kb
 */

require_once 'HTML/QuickForm.php';
require_once 'HTML/QuickForm/advmultiselect.php';

$form = new HTML_QuickForm('amsBasic1');
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

$form->addElement('advmultiselect', 'cars', 'Cars:', $car_array);

if (isset($_POST['cars'])) {
    $form->setDefaults(array('cars' => $_POST['cars']));
}

$form->addElement('submit', 'send', 'Send');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>HTML_QuickForm::advMultiSelect basic example 1</title>
<style type="text/css">
<!--
body {
  background-color: #FFF;
  font-family: Verdana, Arial, helvetica;
  font-size: 10pt;
}
 -->
</style>
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