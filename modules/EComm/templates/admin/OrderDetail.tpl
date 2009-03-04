<h2>Order Details [#{$order->getId()}]</h2>
<b>Order Date: </b>{$order->getCreated()|date_format}<br/>
<b>Status: </b>{$order->getStatus()}<br/>
<b>Total: </b>{$CurrencySign} {$order->getCostTotal()|string_format:"%.2f"}<br/>
<b>Payment Method: </b>{$order->getPaymentClass()}<br/>
<b>Reference number: </b>{$order->getTid()}<br/>

<b>Phone: </b>{$order->getPhone()}<br/>
<b>Email: </b><a href="mailto:{$order->getUserEmail()}">{$order->getUserEmail()}</a><br/>

<br/>
<div style="width:50%;float:left">
	<b>Delivery Info:</b><br/>
	{$order->getShippingStreet()}<br/>
	{$order->getShippingCity()}<br/>
	{$order->getShippingPostal()}<br/>
	{$order->getShippingProvince()}<br/>
	{$order->getShippingCountry()}<br/>
</div>

<div style="width:50%;float:left">
	<b>Billing Info:</b><br/>
	{$order->getBillingStreet()}<br/>
	{$order->getBillingCity()}<br/>
	{$order->getBillingPostal()}<br/>
	{$order->getBillingProvince()}<br/>
	{$order->getBillingCountry()}<br/>
</div>
<br style="clear:both;"/>
<br style="clear:both;"/>

<b>Products:</b><br/>
{foreach from=$orderItems item=orderItem}
	{$orderItem->getQuantity()} X <a href="/Store/Product/{$orderItem->getProduct()}" target="_blank">{$orderItem->getProductName()}</a><br/>
{/foreach}

<br/>
<br/>
<b>Delivery Directions:</b><br/>
{$order->getDeliveryInstructions()|nl2br}<br/>
<br/>
<b>Comments:</b><br/>
{foreach from=$orderComments item=comment}
<b>Status => {$comment->getStatus()}: </b>{$comment->getComment()|nl2br}<br/>
{/foreach}