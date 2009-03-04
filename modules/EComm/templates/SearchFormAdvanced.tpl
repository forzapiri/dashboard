<form method="POST" action="/Store/Search/">
	<input type="hidden" name="action" value="Advanced">
	<div class="OneRow">
		<div class="Label">Product Name</div>
		<div class="Field"><input type="text" name="Name" value="{$Name}"></div>
	</div>
	<div class="OneRow">
		<div class="Label">Category</div>
		<div class="Field">
			<select name="Category">
				<option value=""></option>
				{foreach from=$module->getIndexes('ecomm_category','id','name') key=value item=thingy}
					<option value="{$value}" {if $Category == $value}selected{/if}>{$thingy}</option>
				{/foreach}
			</select>
		</div>
	</div>
	<div class="OneRow">
		<div class="Label">Supplier</div>
		<div class="Field">
			<select name="Supplier">
				<option value=""></option>
				{foreach from=$module->getIndexes('ecomm_supplier','id','name') key=value item=thingy}
					<option value="{$value}" {if $Supplier == $value}selected{/if}>{$thingy}</option>
				{/foreach}
			</select>
		</div>
	</div>
	<div class="OneRow">
		<div class="Label">Product Type</div>
		<div class="Field">
			<select name="ProductType">
				<option value=""></option>
				{foreach from=$module->getIndexes('ecomm_product_type','id','name') key=value item=thingy}
					<option value="{$value}" {if $ProductType == $value}selected{/if}>{$thingy}</option>
				{/foreach}
			</select>
		</div>
	</div>
	<div class="OneRow">
		<div class="Label">Price</div>
		<div class="Field">
			<select name="PriceOp">
				<option value=""></option>
				<option value="less" {if $PriceOp == "less"}selected{/if}>Less than</option>
				<option value="greater" {if $PriceOp == "greater"}selected{/if}>Greater than</option>
				<option value="between" {if $PriceOp == "between"}selected{/if}>Between</option>
			</select>
			<input type="text" name="Price1" size=3 value="{$Price1}"> - 
			<input type="text" name="Price2" size=3 value="{$Price2}"> 
		</div>
	</div>
	<input type="submit" name="btnSubmit" value="Search">
	<a href="/Store/Search&action=Simple">Simple Search</a>
</form>
{if $btnSubmit}
	{include file="SearchResults.tpl"}
{/if}