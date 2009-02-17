<url>{math equation="1 / y" y=$depth assign=priority}
	<loc>{$server}{$item->link}</loc>
	<priority>{$priority|string_format:"%.1f"}</priority>
</url>
{foreach from=$item->children item=item}
{include file=url.tpl depth=$depth+1}
{/foreach}