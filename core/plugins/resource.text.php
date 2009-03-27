<?php
/**
 *  This file is part of Dashboard.
 *
 *  Dashboard is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Dashboard is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Dashboard.  If not, see <http://www.gnu.org/licenses/>.
 *  
 *  @license http://www.gnu.org/licenses/gpl.txt
 *  @copyright Copyright 2007-2009 Norex Core Web Development
 *  @author See CREDITS file
 *
 */
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
