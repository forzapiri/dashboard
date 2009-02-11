
<div id="buttons">
	<ul id="primary">
		<li><a href="/admin/DBTable&amp;action=createTable" title="Create Table" class="create">Create Table</a></li>
	</ul>
</div>
<table border="0" cellspacing="0" cellpadding="0" class="admin_list">
<thead>
	<tr>
		<th width='10'></th>
		<th valign="center">Table name</th>
		<th valign="center">Columns</th> 
	</tr>
</thead>
<tbody>
{foreach from=$tables key=table item=rows}
	<tr class="{cycle values="row1,row2"}">
		<td width='10'>
			<form action="/admin/DBTable" method="post" onsubmit="return !formSubmit(this);">
			<input type="hidden" name="action" value="view" />
			<input type="hidden" name="table" value="{$table}" />
		   	<input type="image" src="/images/admin/{if ($viewtable && ($name == $table))}yellow{else}orange{/if}-bullet.gif" />
			</form>
		</td>
		<td>{$table}</td>
		<td>
 	{foreach from=$rows item=row}
 		{$row->getName()}
 	{/foreach}
		</td>
	</tr>
{/foreach}
</tbody>
</table>

{if ($viewtable)}
<div id="buttons">
	<ul id="primary">
		<li><a href="/admin/DBTable&amp;action=addColumn&amp;table={$name}" title="Add Column">Add Column</a></li>
	</ul>
</div>

<h1 style="float: left;">{$name}</h1>

<table border="0" cellspacing="0" cellpadding="0" class="admin_list">
<thead>
	<tr>
		<th colspan="5" align="center">DBRow</th>
		<th colspan="3" align="center">------------- MySQL ------------</th>
	</tr>
	<tr>
		<th valign="center">Name</th> 
		<th valign="center">Type</th>
		<th valign="center">Label</th> 
		<th valign="center">Modifier</th> 
		<th valign="center">Actions</th>
		<th valign="center" width="100">actual</th>
		<th valign="right" width="5"></th> 
		<th valign="center" width="100">suggested</th>
	</tr>
</thead>
<tbody>
{foreach from=$viewtable item=column}
	<tr class="{cycle values="row1,row2"}">
		<td>{$column->getName()}</td>
		<td>{$column->getType()}</td>
		<td>{$column->getLabel()}</td>
		<td>{$column->getModifier()}</td>
		<td class="actions">
		{if ($column->getName() != 'id')}
		<form action="/admin/DBTable" method="post" onsubmit="return !thickboxAddEdit(this);">
			<input type="hidden" name="action" value="addedit" />
			<input type="hidden" name="id" value="{$column->getId()}" />
			<input type="image" src="/images/admin/pencil.gif" />
		</form>
		<form action="/admin/DBTable" method="post" onsubmit="return !deleteConfirm({$column->getId()});">
            <input type="hidden" name="action" value="delete" />
			<input type="hidden" name="id" value="{$column->getId()}" />
			<input type="image" src="/images/admin/page_delete.gif" /></td>
		</form>
		{/if}
		</td>
		<td width="100">{$mysqltable->getType($column->getName())}</td>
		<td valign="right" width="5">
			{if ($column->suggestedMysql() && ($column->suggestedMysql() != $mysqltable->getType($column->getName())))}
				<form action="/admin/DBTable" method="post" onsubmit="return !formSubmit(this);">
				<input type="hidden" name="action" value="setType" />
				<input type="hidden" name="table" value="{$table}" />
				<input type="hidden" name="id" value="{$column->getId()}" />
		   		<input type="image" src="/images/admin/arrow_turn_right.gif" />
				</form>
			{/if}
		</td>
		<td width="100">{$column->suggestedMysql()}</td>
	</tr>
{/foreach}
</tbody>
</table>
{/if}
