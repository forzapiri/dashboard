<?php
  // $smarty->assign('foo', 'world');
  // echo $smarty->fetch('text:Hello {$foo}!'); // Hello world!
function smarty_resource_text_source($tpl_name, &$tpl_source, &$smarty_obj) {
    $tpl_source = $tpl_name;
    return true;
}

function smarty_resource_text_timestamp($tpl_name, &$tpl_timestamp, &$smarty_obj) {
    $tpl_timestamp = time();
    return true;
}

function smarty_resource_text_secure($tpl_name, &$smarty_obj) {
    return true;
}

function smarty_resource_text_trusted($tpl_name, &$smarty_obj) {}
