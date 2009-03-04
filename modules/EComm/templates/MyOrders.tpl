<h3>Here are all the orderes that you placed</h3>
<table class="adminList" style="clear: both; float: left;" border="0" cellpadding="0" cellspacing="0">
	<tbody><tr>
		<th valign="center">Date</th>
		<th valign="center">Pay type</th>
		<th valign="center">Status</th>
		<th valign="center">Total</th>
		<th style="width: 50px;" valign="center">View</th>
	</tr>
	
	{foreach from=$results item=obj}
	<tr class="{cycle values="row1,row2"}">
		<td>{$obj->getCreated()|date_format}</td>
		<td>{$obj->getPaymentClass()}</td>
		<td><b>{$obj->getStatus()}</b></td>
		<td>{$CurrencySign} {$obj->getCostTotal()|string_format:"%.2f"}</td>
		<td>
			<form method="POST" action="/Store/MyAccount/&action=MyOrders" style="float: left;" onSubmit="return !requestOrderDetails(this);">
				<input type="hidden" name="order_id" value="{$obj->getId()}" />
				<input type="image" name="view" id="view" value="view" src="/modules/EComm/images/view_order.png" />
			</form>
		</td>
	</tr>
	{/foreach}
</tbody>
</table>
{if !$results}
	<br/><br/><br/><center><h3>You don't have any orders</h3></center>
{/if}