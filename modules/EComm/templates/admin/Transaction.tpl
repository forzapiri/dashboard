{include file="admin/subnavi.tpl"}
<h3>Here, you can view the pending and failed transactions</h3>
<table class="adminList" style="clear: both; float: left;" border="0" cellpadding="0" cellspacing="0">
	<tbody><tr>
		<th valign="center">Date</th>
		<th valign="center">Pay type</th>
		<th valign="center">Status</th>
	</tr>
	
	{foreach from=$results item=obj}
	<tr class="{cycle values="row1,row2"}">
		<td>{$obj->getCreated()|date_format}</td>
		<td>{$obj->getPaymentClass()}</td>
		<td><b>{$obj->getStatus()}</b></td>
	</tr>
	{/foreach}
</tbody>
</table>
{if !$results}
	<br/><br/><br/><center><h3>You don't have any transactions</h3></center>
{/if}