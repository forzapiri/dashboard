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

function smarty_function_block($params,&$smarty) {
	if ($params['class']) {
		$module = Module::factory($params ['class']);
		$module->smarty->assign('module', $module);
		$smarty->assign('blockContent', $module->smarty->fetch($params['template']));
	} else {
		$smarty->assign('blockContent', $smarty->fetch($params['template']));
	}
	if ($params['blockid']) {
		$smarty->assign('blockID', $params['blockid']);
	} else {
		$smarty->clear_assign('blockID');
	}
	
	return $smarty->fetch('block.tpl');
}
