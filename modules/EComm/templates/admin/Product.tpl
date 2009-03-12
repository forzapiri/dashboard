{include file="admin/subnavi.tpl"}
<h3>Here, you can manage the products</h3>
{if $msg}<center><h2>{$msg}</h2></center>{/if}
<a href="/admin/EComm&section=Product&action=addedit">Add a new product</a><br/><br/>

<div>
	<form method="post" name="frmAutoComplete">
		<input type="hidden" id="product_id" name="product_id"/>
		<input type="hidden" name="section" value="Product"/>
		<input type="hidden" name="action" value="addedit"/>
		<input type="text" name="productName" id="productName" autocomplete="off"/>
		<input type="submit" value="Edit Product"/>
		<div id="autocomplete_choices" style="display: none;"/> </div>
	</form>
</div>

{literal}
	<script>
	new Ajax.Autocompleter("productName", "autocomplete_choices", "/admin/EComm&section=Product&action=autoComplete", { paramName: "productName", afterUpdateElement: function(text, li) {
		document.frmAutoComplete.product_id.value = li.id;
	} });
	</script>
{/literal}

<form name="search_frm" method="POST" action="/admin/EComm&section=Product">
	Supplier:
		<select id="Supplier" name="Supplier">
			<option></option>
			{foreach from=$module->getIndexes('ecomm_supplier','id','name') key=value item=thingy}
				<option value="{$value}" {if $smarty.request.Supplier == $value}selected{/if}>{$thingy}</option>
			{/foreach}
		</select>
	Category:
		<select id="Category" name="Category">
			<option></option>
			{foreach from=$module->getIndexes('ecomm_category','id','name') key=value item=thingy}
				<option value="{$value}" {if $smarty.request.Category == $value}selected{/if}>{$thingy}</option>
			{/foreach}
		</select>
	Product Type:
		<select id="ProductType" name="ProductType">
			<option></option>
			{foreach from=$module->getIndexes('ecomm_product_type','id','name') key=value item=thingy}
				<option value="{$value}" {if $smarty.request.ProductType == $value}selected{/if}>{$thingy}</option>
			{/foreach}
		</select>
	<input type="submit" name="btn_search_submit" value="Filter">
</form>
<br style="clear:both;"/>
<br/>
{$pager_links}
<br/>
<table class="adminList" style="clear: both; float: left;" border="0" cellpadding="0" cellspacing="0">
	<tbody><tr>
		<th valign="center">Title</th>
		<th valign="center">Category</th>
		<th valign="center">Price</th>
		<th valign="center">Last modified</th>
		<th valign="center">Image</th>
		<th valign="center">Status</th>
		<th style="width: 50px;" valign="center">Actions</th>
	</tr>
	{foreach from=$results item=obj}
		<tr class="{cycle values="row1,row2"}">
			<td>{$obj->getName()}</td>
			<td>{$obj->getCategory()|get_db_value:ecomm_category:id:name}</td>
			<td>{$CurrencySign} {$obj->getPrice()}</td>
			<td>{$obj->getLastModified()}</td>
			<td>{if $obj->getImage()}<img src="/modules/EComm/images/icon_green_on.gif">{else}<img src="/modules/EComm/images/icon_red_on.gif">{/if}</td>
			<td>{if $obj->getStatus()}<img src="/images/admin/tick.gif">{else}<img src="/images/admin/cross.gif">{/if}</td>
			<td>
				<form method="POST" action="/admin/EComm" style="float: left;">
					<input type="hidden" name="Supplier" value="{$smarty.request.Supplier}">
					<input type="hidden" name="Category" value="{$smarty.request.Category}">
					<input type="hidden" name="ProductType" value="{$smarty.request.ProductType}">
					<input type="hidden" name="pageID" value="{$smarty.request.pageID}" />
					<input type="hidden" name="product_id" value="{$obj->getId()}" />
					<input type="hidden" name="section" value="Product" />
					<input type="hidden" name="action" value="addedit" />
					<input type="image" name="edit" id="edit" value="edit" src="/images/admin/pencil.gif" />
				</form>
				<form method="POST" action="/admin/EComm" onsubmit="return confirm('Are you sure you want to delete this product?');" style="float: left;">
					<input type="hidden" name="Supplier" value="{$smarty.request.Supplier}">
					<input type="hidden" name="Category" value="{$smarty.request.Category}">
					<input type="hidden" name="ProductType" value="{$smarty.request.ProductType}">
					<input type="hidden" name="pageID" value="{$smarty.request.pageID}" />
					<input type="hidden" name="product_id" value="{$obj->getId()}" />
					<input type="hidden" name="section" value="Product" />
					<input type="hidden" name="action" value="delete" />
					<input type="image" name="delete" id="delete" value="delete" src="/images/admin/cross.gif" />
				</form>
			</td>
		</tr>
	{/foreach}

</tbody>
</table>