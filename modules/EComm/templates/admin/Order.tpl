{include file="admin/subnavi.tpl"}
<h3>Here, you can manage the order</h3>
<a href="/admin/EComm&section=Order&allOrders=1">Display all orders</a>
<table class="adminList" style="clear: both; float: left;" border="0" cellpadding="0" cellspacing="0">
	<tbody><tr>
		<th valign="center">Customer</th>
		<th valign="center">Date</th>
		<th valign="center">Pay type</th>
		<th valign="center">Status</th>
		<th valign="center">Total</th>
		<th style="width: 50px;" valign="center">Actions</th>
	</tr>
	
	{foreach from=$results item=obj}
	<tr class="{cycle values="row1,row2"}">
		<td>
			<b>{$obj->getCustomerName()}</b><br/>
			<b>Shipping Address: </b>{$obj->getShippingStreet()}, {$obj->getShippingCity()}, {$obj->getShippingPostal()}, {$obj->getShippingProvince()}, {$obj->getShippingCountry()}<br/>
			<b>Billing Address: </b>{$obj->getBillingStreet()}, {$obj->getBillingCity()}, {$obj->getBillingPostal()}, {$obj->getBillingProvince()}, {$obj->getBillingCountry()}
		</td>
		<td>{$obj->getCreated()|date_format}</td>
		<td>{$obj->getPaymentClass()}</td>
		<td><b>{$obj->getStatus()}</b></td>
		<td>{$CurrencySign} {$obj->getCostTotal()|string_format:"%.2f"}</td>
		<td>
			<form method="POST" action="/admin/EComm" style="float: left;" onsubmit="return !thickboxAddEdit(this);">
				<input type="hidden" name="order_id" value="{$obj->getId()}" />
				<input type="hidden" name="section" value="Order" />
				<input type="hidden" name="action" value="View" />
				<input type="image" name="view" id="view" value="view" src="/modules/EComm/images/view_order.png" />
			</form>
			<form method="POST" action="/admin/EComm" style="float: left;" onsubmit="return !thickboxAddEdit(this);">
				<input type="hidden" name="order_id" value="{$obj->getId()}" />
				<input type="hidden" name="section" value="Order" />
				<input type="hidden" name="action" value="Comment" />
				<input type="image" name="comment" id="comment" value="comment" src="/modules/EComm/images/pencil.gif" />
			</form>
		</td>
	</tr>
	{/foreach}
</tbody>
</table>
{if !$results}
	<br/><br/><br/><center><h3>You don't have any orders</h3></center>
{/if}