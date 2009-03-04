{include file="admin/subnavi.tpl"}
<h2>Shipping Management</h2>
Here, you can manage all your shipping classes
<ul>
	{foreach from=$plugins item=plugin}
		<li><a href="/admin/EComm&section=Shipping&plugin={$plugin}">{$ECommShipping->getPlugin($plugin)->getShippingName()}</a></li>
	{/foreach}
</ul>