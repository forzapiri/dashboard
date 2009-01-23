<table class="adminList tablesorter" cellspacing="0" cellpadding="0" border="0" style="clear: both; float: left;">
<thead>
	<tr>
		<th>Username</th>
		<th>Name</th>
		<th>Email</th>
		<th>User Type</th>
		<th>Status</th>
		<th>Actions *</th> 
	</tr>
</thead>
{foreach from=$users item=user}
	{include file="admin/user_item_row.tpl"}
{/foreach}
	<tr>
		<td colspan="5" class="legend" id="help" style="text-align: left;" valign="top">&nbsp;</td>
		<td colspan="1" class="legend">
			<strong>* Actions:</strong><br />
			Edit Item Details <img src="/images/admin/pencil.gif" alt="Edit Item Details" /><br />
			Delete Item <img src="/images/admin/page_delete.gif" alt="Delete Item" />
		</td>
	</tr>
</table>
