{include file="admin/subnav.tpl"}

<p>In this interface you can create, edit and delete your mailing lists.</p>

<div id="buttons">
	<ul id="primary">
		<li><a class="create" href="/admin/Mail&amp;section=lists&amp;action=addedit" title="Create New Mail List">Create New Mail List</a></li>
	</ul>
</div>

	<table border="0" cellspacing="0" cellpadding="0" class="admin_list">

		<tr>
				<th valign="left">Mailing List</th>
				<th valign="left">Actions</th>
		</tr>
		{foreach from=$lists item=list}
				<tr class="{cycle values="row1,row2"}">
			<td>
				{$list->getListUsersForm()->display()}
			</td>
			<td valign="middle" align="center">
			<form action="/admin/Mail" method="post" onsubmit="return !deleteConfirm(this);">
				<input type="hidden" name="action" value="delete" />
				<input type="hidden" name="section" value="lists" />
				<input type="hidden" name="maillist_id" value="{$list->getId()}" />
				<input type="image" src="/images/admin/cross.gif" />
			</form>
			</td>
		</tr>
		{/foreach}
			</table>