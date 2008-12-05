<?php
/**
 * Basic advMultiSelect HTML_QuickForm element without any customization.
 * Load options from a database.
 *
 * @version    $Id: qfams_basic_2.php,v 1.3 2008/04/26 17:25:59 farell Exp $
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_QuickForm_advmultiselect
 * @subpackage Examples
 * @access     public
 * @example    examples/qfams_basic_2.php
 *             qfams_basic_2 source code
 * @link       http://www.laurent-laville.org/img/qfams/screenshot/basic2.png
 *             screenshot (Image PNG, 605x283 pixels) 5.17 Kb
 */

require_once 'DB.php';
require_once 'HTML/QuickForm.php';
require_once 'HTML/QuickForm/advmultiselect.php';
require_once 'dsn_qfams_basic2.inc';  // dsn data: $user, $pass, @$host, $db

PEAR::setErrorHandling(PEAR_ERROR_DIE);

$dsn = "mysql://$user:$pass@$host/$db";

$db = DB::connect($dsn);

// query to get all users of group #1 (available users list)
$queryAll = 'SELECT userid, CONCAT(lastname, " ", firstname) AS useridentity '
          . 'FROM user WHERE gid = 1';

// query to get all users affected of group #1 (selected users list)
$querySel = 'SELECT userid FROM user WHERE gid = 1 AND affect = 1';

// execute query to get ident of users affected
$affected_user =& $db->getCol($querySel);


$form = new HTML_QuickForm('amsBasic2');
$form->removeAttribute('name');  // XHTML compliance

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

$form->addElement('header', null, 'Advanced Multiple Select: default layout ');

$ams =& $form->addElement('advmultiselect', 'user',
    array('Users:', 'Available', 'Affected'),         // labels
    null,                                             // datas
    array('style' => 'width:200px;')                  // custom layout
);

// load QFAMS values (unselected and selected)
$ams->load($db, $queryAll, 'useridentity', 'userid', $affected_user);

$form->addElement('submit', 'send', 'Send');

// close database connection
$db->disconnect();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>HTML_QuickForm::advMultiSelect basic example 2</title>
<style type="text/css">
<!--
body {
  background-color: #FFF;
  font-family: Verdana, Arial, helvetica;
  font-size: 10pt;
}
pre.sql {
  border: 1px solid silver;
  background-color: lightyellow;
  color: black;
  padding: 1em;
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
} else {
    $form->display();
}
?>

<pre class="sql">
CREATE TABLE user (
   userid VARCHAR(5) NOT NULL,
   gid INT NOT NULL,
   affect INT NOT NULL,
   lastname VARCHAR(50)NOT NULL,
   firstname VARCHAR(50) NOT NULL,
   PRIMARY KEY (userid)
);

INSERT INTO user VALUES ('MJ001', 1, 0, 'Martin', 'Jansen');
INSERT INTO user VALUES ('BG001', 1, 1, 'Greg', 'Beaver');
INSERT INTO user VALUES ('CD001', 1, 0, 'Daniel', 'Convissor');
INSERT INTO user VALUES ('LL001', 2, 1, 'Laurent', 'Laville');
</pre>

</body>
</html>