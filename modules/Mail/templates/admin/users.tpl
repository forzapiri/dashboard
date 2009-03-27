{include file="admin/subnav.tpl"}

<p>In this interface you can create, edit and delete mail recipients.</p>

<div id="buttons">
	<ul id="primary">
		<li><a class="create" href="/admin/Mail&amp;section=users&amp;action=addedit" title="Create New Recipient">Create New Recipient</a></li>
	</ul>
</div>

	<table border="0" cellspacing="0" cellpadding="0" class="admin_list">

		<tr>
				<th valign="center">E-Mail Address</th>

				<th valign="center">Name</th>
				<th valign="center">Actions</th>
		</tr>
		{foreach from=$users item=user}
				<tr class="{cycle values="row1,row2"}">
			<td>
				{$user->getEmail()}
			</td>
			<td>
				{$user->getFirstName()}&nbsp;{$user->getLastName()} 
			<td class="center">
				<form action="/admin/Mail" method="post" style="float: left;">
					<input type="hidden" name="section" value="users" />
					<input type="hidden" name="action" value="addedit" />
					<input type="hidden" name="mailuser_id" value="{$user->getId()}" />
					<input type="image" src="/images/admin/pencil.gif" />
				</form>

				<form action="/admin/Mail" class="delete" method="post" style="float: left;" onsubmit="return !deleteConfirm(this);">
					<input type="hidden" name="section" value="users" />
					<input type="hidden" name="action" value="delete" />
					<input type="hidden" name="mailuser_id" value="{$user->getId()}" />
					<input type="image" src="/images/admin/cross.gif" />
				</form>
			</td>

		</tr>
		{/foreach}
			</table>