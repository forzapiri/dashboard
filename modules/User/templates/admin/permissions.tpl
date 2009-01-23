<div id="permissions">
{include file="admin/subnav.tpl"}

<h3>Permissions Management</h3>

<table class="adminList" cellspacing="0" cellpadding="0" border="0" style="clear: both; float: left;">
<thead>

	<tr>
		<th>&nbsp;</th>
		{foreach from=$groups item=group}
		<th>{$group->getName()}</th>
		{/foreach}
	</tr>
</thead>
	{foreach from=$permissions item=perm}
	<tr class="{cycle values="row1,row2"}">
		<td>{$perm->getTitle()}</td>
		{foreach from=$groups item=group}
		<td>
		<form method="post" action="/admin/User" onsubmit="return !submitPermissions(this);">
		<input type="hidden" name="section" value="permission" />
		<input type="hidden" name="action" value="toggle" />
		<input type="hidden" name="perm" value="{$perm->getId()}" />
		<input type="hidden" name="group" value="{$group->getId()}" />    
		{if $group->hasPerm($perm->getKey())}
		<input name="togglePerm" id="togglePerm" value="true" src="/images/admin/tick.gif" type="image" />
		{else}
		<input name="togglePerm" id="togglePerm" value="false" src="/images/admin/cross.gif" type="image" />
		{/if}
		</form>
		</td>
		{/foreach}
	</tr>
	{/foreach}
</table>
</div>