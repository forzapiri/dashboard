{if $msg}<center><h2>{$msg}</h2></center>{/if}
Here are the items in your cart:<br/>
<table id="cartItems" name="cartItems" border="1" style="border-collapse: collapse;" width="100%">
	<tr>
		<th>Delete</th>
		<th>Product</th>
		<th>Photo</th>
		<th>Quantity</th>
		<th>Price / Unit</th>
		<th>Total</th>
	</tr>
	{foreach from=$cartProducts item=cartProduct}
		{assign var="quantity" value=$cartProduct->getQuantity()}
		{assign var="product" value=$cartProduct->getCartItemProduct()}
		{assign var="productPrice" value=$cartProduct->calculatePrice()}
		{math equation="x * y" x=$productPrice y=$quantity assign=totalProductPrice}
		<tr id="row_{$cartProduct->getId()}" name="row_{$cartProduct->getId()}">
			<td><a href="javascript:removeProductFromCart({$cartProduct->getId()})"><img border=0 src="/modules/EComm/images/delete.gif"></a></td>
			<td><a href="/Store/Cart/&action=displayCartProduct&cartItemId={$cartProduct->getId()}&returnURL={$page}">{$product->getName()}</a></td>
			<td>{*<img src="/images/image.php?id={$product->getImage()}&cliph=40">*}</td>
			<td>{$quantity}</td>
			<td>{$CurrencySign} {$productPrice|string_format:"%.2f"}</td>
			<td>{$CurrencySign} {$totalProductPrice|string_format:"%.2f"}</td>
		</tr>
	{/foreach}
	<tr>
		<td colspan="5" align="right">Subtotal:</td>
		<td id="cartDetailsSubTotal">{$CurrencySign} {$cartDetails.subTotal}</td>
	</tr>
	<tr>
		<td colspan="5" align="right">Tax:</td>
		<td id="cartDetailsTax">{$CurrencySign} {$cartDetails.tax}</td>
	</tr>
	<tr>
		<td colspan="5" align="right">Shipping:</td>
		<td id="cartDetailsShipping">{$CurrencySign} {$cartDetails.shipping}</td>
	</tr>
	<tr>
		<td colspan="5" align="right">Total:</td>
		<td id="cartDetailsTotal">{$CurrencySign} {$cartDetails.total}</td>
	</tr>
</table>