{include file="admin/subnav.tpl"}

<h3>Groups Management</h3>

<div id="header">
	<ul id="primary">
		<li><a href="/admin/User&section=group&action=addedit" title="Create Group" id="creategroup">Create Group</a></li>
	</ul>
</div>

<div id="group_table">
<table class="adminList" cellspacing="0" cellpadding="0" border="0" style="clear: both; float: left;">
<thead>
	<tr>
		<th>Name</th>
		<th>Number of Members</th>
		<th>Actions</th>
	</tr>
</thead>
	{foreach from=$groups item=group}
	<tr class="{cycle values="row1,row2"}">
		<td>{$group->getName()}</td>
		<td>{$group->getMembers()|@count}</td>
				<td class="actions">
			<form method="post" action="/admin/User" onsubmit="return !thickboxAddEdit(this);">
				<input name="id" value="{$group->getId()}" type="hidden">
				<input name="section" value="group" type="hidden">
				<input name="action" value="addedit" type="hidden">
				<input name="edit" id="edit" value="edit" src="/images/admin/pencil.gif" type="image">
			</form>
			<form method="post" action="/admin/User" onsubmit="return !deleteConfirm(this);">
				<input name="id" value="{$group->getId()}" type="hidden">
				<input name="section" value="group" type="hidden">
				<input name="action" value="delete" type="hidden">
				<input name="delete" id="delete" value="delete" src="/images/admin/cross.gif" type="image">
			</form>
			
		</td>
	</tr>
	{/foreach}
</table>
</div>
<div id="thickbox_wrapper" style="display: none;">
	<div id="thickbox_header" style="display: block;">&nbsp;</div>
	<div id="thickbox">&nbsp;</div>
	<div id="thickbox_footer">&nbsp;</div>
</div>