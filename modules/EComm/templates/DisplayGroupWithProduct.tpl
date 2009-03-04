{assign var="returnURL" value="/Store"}
{if $group}
	{assign var="secId" value=$group->getId()}
	{assign var="returnURL" value="/Store/$section/$secId"}
{/if}

{if $group && $section=="Category"}
	{include file="Category.tpl"}
{/if}

{if $group && $section=="ProductType"}
	{include file="ProductType.tpl"}
{/if}

{if $group && $section=="Supplier"}
	{include file="Supplier.tpl"}
{/if}

{if $results}
	{include file="DisplayGroup.tpl"}
{/if}

{if $products}
	{include file="SearchResults.tpl"}
{/if}
