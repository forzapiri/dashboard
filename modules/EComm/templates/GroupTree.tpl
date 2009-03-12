{if !$ajax}
	<div id="TreeGroups">
		<ul>
{/if}

{foreach from=$groups item=group}
	<li>
		{if $action == "Category"}<a id="group_{$group->getId()}" href="javascript:expandTree({$group->getId()}, '{$action}')">(+)</a>{/if}
		<a href="javascript:displayProducts({$group->getId()}, '{$action}')">{$group->getName()}</a>
		<ul id="children_{$group->getId()}">
		</ul>
	</li>
{/foreach}

{if !$ajax}
		</ul>
	</div>
	<div id="TreeProducts">
	</div>
{/if}
