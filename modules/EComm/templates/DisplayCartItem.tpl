{if $msg}<center><h2>{$msg}</h2></center>{/if}
{assign var=product value=$cartItem->getCartItemProduct()}
{if $product}
	<h2>Product: {$product->getName()}</h2>
	<div class="CellInfo">
		<div class="CellInfoImage">
			{if $product->getImage()}
				<img id="productImage" border=0 src="/images/image.php?id={$product->getImage()}&cliph=140">
			{else}
				<img id="productImage" border=0 src="/modules/EComm/images/no_image.gif">
			{/if}
		</div>
		<div class="CellInfoDetails">
			{$product->getDetails()}
			<br style="clear:both;"/>
			<b>Price: </b>{$CurrencySign} {$product->getPrice()}
			<br style="clear:both;"/>
			{assign var="productFinalPrice" value=$cartItem->calculatePrice()}
			{if $productFinalPrice != $product->getPrice()}
				<b>Final price per product:</b>{$CurrencySign} {$productFinalPrice}<br/>
			{/if}
			<br style="clear:both;"/>
			<b>Category: </b>{$product->getCategory()|get_db_value:ecomm_category:id:name}<br style="clear:both;"/>
			<b>Product Type: </b>{$product->getProducttype()|get_db_value:ecomm_product_type:id:name}<br style="clear:both;"/>
			<b>Supplier: </b>{$product->getSupplier()|get_db_value:ecomm_supplier:id:name}<br style="clear:both;"/>
			<br style="clear:both;"/>
			<b>Quantity: </b>{$cartItem->getQuantity()}
			<br style="clear:both;"/><br/>
			{$html}
		</div>
	</div>
	<a href="{$returnURL}">Go back</a>
{/if}