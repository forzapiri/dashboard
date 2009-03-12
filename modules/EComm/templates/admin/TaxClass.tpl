{include file="admin/subnavi.tpl"}
<h3>Here, you can manage the tax classes</h3>
<a href="/admin/EComm&section=TaxClass&action=addedit">Add a new tax class</a>

<table class="adminList" style="clear: both; float: left;" border="0" cellpadding="0" cellspacing="0">
	<tbody><tr>
		<th valign="center">Title</th>
		<th valign="center">Last modified</th>
		<th valign="center">Status</th>
		<th style="width: 50px;" valign="center">Actions</th>
	</tr>
	
	{foreach from=$results item=obj}
	<tr class="{cycle values="row1,row2"}">
		<td>{$obj->getName()}</td>
		<td>{$obj->getLastModified()}</td>
		<td>{if $obj->getStatus()}<img src="/images/admin/tick.gif">{else}<img src="/images/admin/cross.gif">{/if}</td>
		<td>
			<form method="POST" action="/admin/EComm" style="float: left;">
				<input type="hidden" name="taxclass_id" value="{$obj->getId()}" />
				<input type="hidden" name="section" value="TaxClass" />
				<input type="hidden" name="action" value="addedit" />
				<input type="image" name="edit" id="edit" value="edit" src="/images/admin/pencil.gif" />
			</form>
			<form method="POST" action="/admin/EComm" onsubmit="return !deleteConfirm(this);" style="float: left;">
				<input type="hidden" name="taxclass_id" value="{$obj->getId()}" />
				<input type="hidden" name="section" value="TaxClass" />
				<input type="hidden" name="action" value="delete" />
				<input type="image" name="delete" id="delete" value="delete" src="/images/admin/cross.gif" />
			</form>
		</td>
	</tr>
	{/foreach}

</tbody>
</table>