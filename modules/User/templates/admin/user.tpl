{include file="admin/subnav.tpl"}

<p>This interface allows you to add, edit and delete users. Disabled users will keep all their account information intact, but will be unable to log in.</p>

<div id="header">
	<ul id="primary">
		<li><a href="/admin/User&amp;section=user&amp;action=addedit" id="create_user" title="Create User">Create User</a></li>
	</ul>
</div>

<div id="user_table">
{include file="admin/user_table.tpl"}
</div>
