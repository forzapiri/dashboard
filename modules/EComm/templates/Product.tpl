{if $msg}<center><h2>{$msg}</h2></center>{/if}
{if $product}
	<h2>Product: {$product->getName()}</h2>
	<form method=POST action="/Store/Cart/&action=Add">
		<input type="hidden" name="productId" value="{$product->getId()}">
		<input type="hidden" name="returnURL" value="{$returnURL}">
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
				<b>Category: </b>{$product->getCategory()|get_db_value:ecomm_category:id:name}<br style="clear:both;"/>
				<b>Product Type: </b>{$product->getProducttype()|get_db_value:ecomm_product_type:id:name}<br style="clear:both;"/>
				<b>Supplier: </b>{$product->getSupplier()|get_db_value:ecomm_supplier:id:name}<br style="clear:both;"/>
				<br style="clear:both;"/>
				<b>Quantity: </b><input type="text" name="quantity" size=3 value="1">
				<br style="clear:both;"/><br/>
				{$html}
				<input type="image" src="/modules/EComm/images/addToCart.jpg" name="addToCart" id="addToCart"/>
			</div>
		</div>
	</form>
	<a href="{$returnURL}">Go back</a>
{/if}