<?php
function smarty_function_siteconfig($params, &$smarty) {
	if ($params['info'] == 'memory') return number_format(memory_get_peak_usage() / 1024, 0, '.', ',') . " KB";
	if ($params['info'] == 'render_time') {
		global $startTime;
		return number_format(microtime(true) - $startTime, 3);
	}
	return SiteConfig::get($params['get']);
}
?> 