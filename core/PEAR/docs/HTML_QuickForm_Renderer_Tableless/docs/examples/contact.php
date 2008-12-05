<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
    <style type="text/css">
/* this style is used only for this example to make it look better */
/* only the second block (it's the same as in data/stylesheet.css) is relevant */
body {
    margin-left: 10px;
    font-family: Arial,sans-serif;
    font-size: small;
}
    </style>
    <style type="text/css">
form {
    margin: 0;
    padding: 0;
    min-width: 500px;
    max-width: 600px;
    width: 560px;
}
form fieldset {
    clear: both;
    float: left;
    border: 0;
    margin: 0;
    width: 100%;
}
form fieldset.hidden {
    border: 0;
}
form fieldset legend {
    white-space: nowrap;
    background-color: #CCCCCC;
    font-weight: bold;
    width: 100%;
    padding: 1px;
    display: block;
}
form fieldset ol {
    margin: 0;
    padding: 0;
}
form fieldset li {
    display: block;
    list-style: none;
    margin: 0;
    clear: both;
}
form label {
    margin: 0 0 0 5px;
}
form label.element {
    display: block;
    float: left;
    width: 150px;
    padding: 0;
    margin: 5px 0 0 0;
    font-weight: bold;
    text-align: right;
}
form input, form textarea, form select {
    width: auto;
}
form textarea {
    overflow: auto;
}
form br {
    clear: left;
}
form div.element {
    display: inline;
    float: left;
    margin: 5px 0 0 10px;
    padding: 0;
}
form li.reqnote {
    font-size: 80%; 
    margin: 5px 0 0 10px;
}
form span.error, form span.required {
    color: red;
}
form div.error {
    border: 1px solid red;
    padding: 5px;
}
    </style>
    <title>HTML_QuickForm_Renderer_Tableless example</title>
  </head>
  <body>
<?php

require_once 'HTML/QuickForm.php';
require_once 'HTML/QuickForm/Renderer/Tableless.php';

$form = new HTML_QuickForm('contact', null, null, null, null, true);
$form->removeAttribute('name');  // for XHTML validity

$form->addElement('header', 'header', 'Tableless renderer example');

$form->addElement('text', 'name', 'Your name:', array('style' => 'width: 300px;'));
$form->addElement('text', 'email', 'Your email:', array('style' => 'width: 300px;'));
$form->addElement('text', 'emptylabel', '', array('style' => 'width: 300px;'));
$form->addElement('text', null, 'Element without name:', array('style' => 'width: 300px;'));
$form->addElement('text', '', 'Element with empty name:', array('style' => 'width: 300px;'));
$form->addElement('text', 'subject', 'Your subject:', array('style' => 'width: 300px;'));
$form->addElement('checkbox', 'single', 'Checkbox example:', ' Check me if you agree to receive spam ;-)');

$form->addElement('header', 'header2', 'Some groups');

$radio = array();
$radio[] = &HTML_QuickForm::createElement('radio', 'country', null, 'France', 'france');
$radio[] = &HTML_QuickForm::createElement('radio', 'country', null, 'Germany', 'germany');
$radio[] = &HTML_QuickForm::createElement('radio', 'country', null, 'Austria', 'austria');
$radio[] = &HTML_QuickForm::createElement('radio', 'country', null, 'Other', 'other');
$form->addGroup($radio, 'group1', 'Choose a country:', ' ');

$form->addElement('date', 'date', 'Date:', array('format' => 'Y-m-d H:i', 'optionIncrement' => array('i' => 5)));

$checkbox = array();
$checkbox[] = &HTML_QuickForm::createElement('checkbox', 'A1', null, 'France');
$checkbox[] = &HTML_QuickForm::createElement('checkbox', 'B1', null, 'Germany');
$checkbox[] = &HTML_QuickForm::createElement('checkbox', 'C1', null, 'Austria');
$checkbox[] = &HTML_QuickForm::createElement('checkbox', 'D1', null, 'Other');
$form->addGroup($checkbox, 'group2', 'Choose a country:', ' ');

$checkbox = array();
$checkbox[] = &HTML_QuickForm::createElement('checkbox', 'A2', null, 'France');
$checkbox[] = &HTML_QuickForm::createElement('checkbox', 'B2', null, 'Germany');
$checkbox[] = &HTML_QuickForm::createElement('checkbox', 'C2', null, 'Austria');
$checkbox[] = &HTML_QuickForm::createElement('checkbox', 'D2', null, 'Other');
$form->addGroup($checkbox, 'group3', 'Choose a country:', '<br />');

$form->addElement('header', 'header3', 'The third fieldset');

$main[0] = 'Pop';
$main[1] = 'Rock';
$main[2] = 'Classical';

$secondary[0][0] = 'Belle &amp; Sebastian';
$secondary[0][1] = 'Elliot Smith';
$secondary[0][2] = 'Beck';
$secondary[1][3] = 'Noir Desir';
$secondary[1][4] = 'Violent Femmes';
$secondary[2][5] = 'Wagner';
$secondary[2][6] = 'Mozart';
$secondary[2][7] = 'Beethoven';

$select =& $form->addElement('hierselect', 'music', 'Please select:');
$select->setOptions(array($main, $secondary));

$form->addElement('textarea', 'message', 'Your message:', array('style' => 'width: 300px;', 'cols' => 50, 'rows' => '7'));
$form->addElement('submit', 'submit', 'Submit');

$form->addElement('hidden', 'hidden1', 'x');
$form->addElement('hidden', 'hidden2', 'y');
$form->addElement('hidden', 'hidden3', 'z');

$form->addRule('name', 'Please enter your name', 'required', null, 'client');
$form->addRule('email', 'Please enter your email address.', 'required', null, 'client');
$form->addRule('email', 'Please enter a valid email address.', 'email', null, 'client');
$form->addRule('subject', 'Please enter a subject.', 'required', null, 'client');
$form->addRule('message', 'Please enter a message.', 'required', null, 'client');

if ($form->isSubmitted() && $form->validate()) {
  $data = $form->exportValues();
  // do something with $data
  echo "<p>Thank you</p>\n";
}
else {
  $renderer =& new HTML_QuickForm_Renderer_Tableless();
  $renderer->addStopFieldsetElements('submit');
  $form->accept($renderer);
  echo $renderer->toHtml();
}

?>
  </body>
</html>