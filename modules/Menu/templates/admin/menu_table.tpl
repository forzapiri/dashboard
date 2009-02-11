<table border="0" cellspacing="0" cellpadding="0" class="admin_list">
<thead>
	<tr>
		<th valign="center">Menu Item *</th>
		<th valign="center">Links To</th>
		<th valign="center">Opens In</th>
		<th valign="center" style="width: 60px">Active? **</th>
		<th valign="center">Actions ***</th> 
	</tr>
</thead>
<tbody id="menuTable">
{foreach from=$menu item=item}
	{include file="admin/menu_item_row.tpl"}
{/foreach}
</tbody>
	<tr>
		<td colspan="3" class="legend" id="help" style="text-align: left;" valign="top"></td>
		<td colspan="2" class="legend">
			<strong>* Menu Item:</strong><br />
			Move Item Down <img src="/images/admin/arrow_down.gif" alt="Move Item Down"><br />

			Move Item Up <img src="/images/admin/arrow_up.gif" alt="Move Item Up"><br /><br />
			<strong>** Active?:</strong><br />
			click icon to change status<br /><br />
			<strong>*** Actions:</strong><br />
			Edit Item Details <img src="/images/admin/pencil.gif" alt="Edit Item Details"><br />
			Delete Item <img src="/images/admin/cross.gif" alt="Delete Item">
		</td>
	</tr>

</table>
