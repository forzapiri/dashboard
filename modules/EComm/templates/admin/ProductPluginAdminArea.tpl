{include file="admin/subnavi.tpl"}<br/>
<h2>Product Plugin administration area</h2>
<h3>{$ECommPlugins->getPlugin($plugin)->getPluginName()}: </b>{$ECommPlugins->getPlugin($plugin)->getPluginDetails()}</h3>
{$ECommPlugins->getPlugin($plugin)->getAdminInterface()}
