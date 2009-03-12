{include file="admin/subnavi.tpl"}
<h2>Product Plugins</h2>
Here, you can view all the active product plugins<br/><br/>
<ul>
	{foreach from=$plugins item=plugin}
		{if $ECommPlugins->getPlugin($plugin)->hasAdminInterface()}
			<li><a href="/admin/EComm&section=Plugins&page={$plugin}"><b>{$ECommPlugins->getPlugin($plugin)->getPluginName()}: </b>{$ECommPlugins->getPlugin($plugin)->getPluginDetails()}</a></li>
		{else}
			<li><b>{$ECommPlugins->getPlugin($plugin)->getPluginName()}: </b>{$ECommPlugins->getPlugin($plugin)->getPluginDetails()}</li>
		{/if}
	{/foreach}
</ul>