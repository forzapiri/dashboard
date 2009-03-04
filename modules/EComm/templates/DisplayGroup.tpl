{if $msg}<center><h2>{$msg}</h2></center>{/if}
{if $section=='Category'}<h2>Categories:</h2>{/if}
{if $section=='ProductType'}<h2>Product Types:</h2>{/if}
{if $section=='Supplier'}<h2>Suppliers:</h2>{/if}

{assign var="itemsPerRow" value="3"}

{assign var="counter" value="0"}
{foreach from=$results item=obj}
	{assign var="counter" value=$counter+1}
	
	{assign var="objId" value=$obj->getId()}
	{assign var="detailsURL" value="/Store/$section/$objId"}
	
	{if $counter % $itemsPerRow == 1 || $itemsPerRow == 1}
		<div class="OneRow">
	{/if}
	<div class="Cell">
		<a href="{$detailsURL}">
			{if $obj->getImage()}
				<img border=0 src="/images/image.php?id={$obj->getImage()}&cliph=140">
			{else}
				<img border=0 src="/modules/EComm/images/no_image.gif">
			{/if}
		</a>
		<br/>
		<a href="{$detailsURL}">
			{$obj->getName()}
		</a>
	</div>
	{if $counter % $itemsPerRow == 0 || $itemsPerRow == 1}
		</div>
	{/if}
{/foreach}
{if $counter % $itemsPerRow != 0}
	</div>
{/if}
<br style="clear:both;"/>
