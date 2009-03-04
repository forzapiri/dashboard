<h2>Products:</h2>
{if !$products}
	<p>No products found</p>
{/if}
{assign var="itemsPerRow" value="3"}

{assign var="counter" value="0"}
{foreach from=$products item=product}
	{assign var="counter" value=$counter+1}

	{assign var="objId" value=$product->getId()}
	{assign var="detailsURL" value="/Store/Product/$objId&returnURL=$returnURL"}

	{if $counter % $itemsPerRow == 1 || $itemsPerRow == 1}
		<div class="OneRow">
	{/if}
	<div class="Cell">
		<a href="{$detailsURL}">
			{if $product->getImage()}
				<img border=0 src="/images/image.php?id={$product->getImage()}&cliph=140">
			{else}
				<img border=0 src="/modules/EComm/images/no_image.gif">
			{/if}
		</a>
		<br/>
		<a href="{$detailsURL}">
			{$product->getName()} (({$counter}))
		</a>
		<br/>
		{$CurrencySign} {$product->getPrice()}
	</div>
	{if $counter % $itemsPerRow == 0 || $itemsPerRow == 1}
		</div>
	{/if}
{/foreach}
{if $counter % $itemsPerRow != 0}
	</div>
{/if}
