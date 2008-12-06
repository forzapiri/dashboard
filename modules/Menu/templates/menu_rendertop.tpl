<div id="nav">
<ul id="navUl">
{foreach from=$menu item=item}
	{strip}<li><a href="{$item->getLinkTarget()}"{if $item->getTarget() == "new"} target="_blank"{/if}>{$item->getDisplay()}</a>
	{if $item->children}{assign var="children" value=true}<ul>{else}{assign var="children" value=false}{/if}
	{foreach from=$item->children item=item}
	{assign var="depth" value=1}
	{include file=menu_renderitems.tpl menu=item}
	{/foreach}
	{if $children}</ul>{/if}
	</li>{/strip}
	
	<li class="menuDivider">&nbsp;</li>
	{/foreach}
</ul>
</div>