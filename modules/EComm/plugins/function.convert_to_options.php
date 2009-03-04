<?php
function smarty_function_convert_to_options($params,&$smarty) {
  $results = "";
  foreach ($params as $key => $value)
    $results .= '<option id="' . $key . '">' . $value . '</option>';
  echo $results;
}
?>