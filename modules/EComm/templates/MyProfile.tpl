<h1>Personal Information</h1>
{if $profileHasBeenChanged}
	Your profile has been changed successfully
{/if}
{$form->display()}

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
