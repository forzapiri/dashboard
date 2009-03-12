<form name="frm_cartsearch" method="POST" action="{$module->getModulePrefix()}Search/">
<input type="hidden" name="action" value="Advanced">
<input type="hidden" name="btnSubmit" value="Search">
<table width="240" border="0">
	<tr>
	  <td><h3>Supplier</h3></td>
	</tr>
	<tr>
	  <td>
	  	<select class="orderSelect" id="selSupplier" name="Supplier">
			<option value="">All</option>
			{foreach from=$module->getIndexes('ecomm_supplier','id','name') key=value item=thingy}
				<option value="{$value}" {if $smarty.post.Supplier == $value}selected{/if}>{$thingy}</option>
			{/foreach}
		</select>
	  </td>
	</tr>
	<tr>
	  <td><h3>Category</h3></td>
	</tr>
	<tr>
	  <td>
	  	<select class="orderSelect" id="selCategory" name="Category">
			<option value="">All</option>
			{foreach from=$module->getIndexes('ecomm_category','id','name') key=value item=thingy}
				<option value="{$value}" {if $smarty.post.Category == $value}selected{/if}>{$thingy}</option>
			{/foreach}
		</select>
	  </td>
	</tr>
	<tr>
	  <td><h3>Product Type</h3></td>
	</tr>
	<tr>
	  <td>
	  	<select class="orderSelect" id="selProductType" name="ProductType">
			<option value="">All</option>
			{foreach from=$module->getIndexes('ecomm_product_type','id','name') key=value item=thingy}
				<option value="{$value}" {if $smarty.post.ProductType == $value}selected{/if}>{$thingy}</option>
			{/foreach}
		</select>
	  </td>
	</tr>
	<tr>
	  <td><h3>Order products 24 hours a day whenever it's convenient for you!</h3><br /></td>
	</tr>
	<tr>
	  <td><input type="image" src="/images/searchBtn.jpg" /></td>
	</tr>
</table>
</form>