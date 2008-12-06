<li><a href="{$item->getLinkTarget()}" style="padding-left: {math equation="x * 10" x=$depth}px!important;"{if $item->getTarget() == "new"} target="_blank"{/if}>{$item->getDisplay()}</a></li>

{foreach from=$item->children item=item}
	{include file=menu_renderitems.tpl menu=item depth=$depth+1}
{/foreach}