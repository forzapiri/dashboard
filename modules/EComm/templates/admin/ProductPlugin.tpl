{include file="admin/subnavi.tpl"}
<h2>Product Plugins</h2>
Here, you can view all the active product plugins<br/><br/>
<ul>
	{foreach from=$plugins item=plugin}
		<li><b>{$ECommPlugins->getPlugin($plugin)->getPluginName()}: </b>{$ECommPlugins->getPlugin($plugin)->getPluginDetails()}</li>
	{/foreach}
</ul>