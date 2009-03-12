{include file="CartDetails.tpl" page="Checkout"}
Check out as user: {$username}<br/>
<h1>Phone number</h1>
<div id="phone_number">
	{include file="PhoneNumber.tpl" phoneNumber=$userDetails->getPhoneNumber()}
</div>

<h1>Billing Address</h1>
<div id="billing_address">
	{include file="Address.tpl" address=$userDetails->getAddress('billing_address') adr_type="billing_address"}
</div>

<h1>Shipping Address</h1>
<div id="shipping_address">
	{include file="Address.tpl" address=$userDetails->getAddress('shipping_address') adr_type="shipping_address"}
</div>

<h1>Shipping Class</h1>
<div id="shipping_class">
	{assign var="shipping_plugins" value=$shippingClass->getActivePluginIDs()}
	<div id="shippingClassSelect">
		<select id="shipping_option" name="shipping_option" onChange="javascript:changeShippingClass();">
			{foreach from=$shipping_plugins item=plugin}
				<option value="{$plugin}" {if $plugin == $selectedShipping}selected{/if}>{$shippingClass->getPlugin($plugin)->getShippingName()}</option>
			{/foreach}
		</select>
	</div>
	<div id="shippingClassDetails">{$shippingClassDetails}</div>
</div>

<h1>Delivery Directions:</h1>
<div id="delivery_directions">
	<textarea id="delivery_direction_textarea" cols="50" rows="10"></textarea>
</div>

<h1>Payment Information</h1>
<div id="payment_class">
	{assign var="payment_plugins" value=$paymentClass->getActivePluginIDs()}
	<div id="paymentClassSelect">
		<select id="payment_option" name="payment_option" onChange="javascript:changePaymentClass();">
			{foreach from=$payment_plugins item=plugin}
				<option value="{$plugin}" {if $plugin == $selectedPayment}selected{/if}>{$paymentClass->getPlugin($plugin)->getPaymentName()}</option>
			{/foreach}
		</select>
	</div>
	<div id="paymentClassDetails">{$paymentClassDetails}</div>
</div>
<div id="payment_form">
{$paymentForm}
</div>