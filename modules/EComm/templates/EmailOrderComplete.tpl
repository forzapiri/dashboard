This email is the confirmation of the following order:

Order Details [#{$order->getId()}]
Order Date: {$order->getCreated()|date_format}
Status: {$order->getStatus()}
Total: {$CurrencySign} {$order->getCostTotal()|string_format:"%.2f"}
Payment Method: {$order->getPaymentClass()}
Reference number: {$order->getTid()}

Phone: {$order->getPhone()}
Email: {$order->getUserEmail()}


Delivery Info:
	{$order->getShippingStreet()}
	{$order->getShippingCity()}
	{$order->getShippingPostal()}
	{$order->getShippingProvince()}
	{$order->getShippingCountry()}

Billing Info:
	{$order->getBillingStreet()}
	{$order->getBillingCity()}
	{$order->getBillingPostal()}
	{$order->getBillingProvince()}
	{$order->getBillingCountry()}


Products:
{foreach from=$orderItems item=orderItem}
	{$orderItem->getQuantity()} X {$orderItem->getProductName()}
{/foreach}


Delivery Directions:
{$order->getDeliveryInstructions()}
