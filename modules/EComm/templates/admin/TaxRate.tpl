{include file="admin/subnavi.tpl"}
<h3>Here, you can manage the tax rates</h3>
<a href="/admin/EComm&section=TaxRate&action=addedit">Add a new tax rate</a>

<table class="adminList" style="clear: both; float: left;" border="0" cellpadding="0" cellspacing="0">
	<tbody><tr>
		<th valign="center">Country</th>
		<th valign="center">Province</th>
		<th valign="center">Tax Class</th>
		<th valign="center">Tax Rate</th>
		<th valign="center">Last modified</th>
		<th style="width: 50px;" valign="center">Actions</th>
	</tr>
	
	{foreach from=$results item=obj}
	<tr class="{cycle values="row1,row2"}">
		<td>{$obj->getCountry()|get_db_value:countries:id:name}</td>
		<td>{$obj->getProvince()|get_db_value:states:id:name}</td>
		<td>{$obj->getTaxClass()|get_db_value:ecomm_tax_class:id:name}</td>
		<td>% {$obj->getTaxRate()}</td>
		<td>{$obj->getLastModified()}</td>
		<td>
			<form method="POST" action="/admin/EComm" style="float: left;">
				<input type="hidden" name="taxrate_id" value="{$obj->getId()}" />
				<input type="hidden" name="section" value="TaxRate" />
				<input type="hidden" name="action" value="addedit" />
				<input type="image" name="edit" id="edit" value="edit" src="/images/admin/pencil.gif" />
			</form>
			<form method="POST" action="/admin/EComm" onsubmit="return !deleteConfirm(this);" style="float: left;">
				<input type="hidden" name="taxrate_id" value="{$obj->getId()}" />
				<input type="hidden" name="section" value="TaxRate" />
				<input type="hidden" name="action" value="delete" />
				<input type="image" name="delete" id="delete" value="delete" src="/images/admin/cross.gif" />
			</form>
		</td>
	</tr>
	{/foreach}

</tbody>
</table>