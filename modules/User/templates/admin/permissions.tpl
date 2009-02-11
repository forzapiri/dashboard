<table class="admin_list" cellspacing="0" cellpadding="0" border="0">
<thead>
	<tr>
		<th width='10'></th>
		<th valign="center">Group</th>
	</tr>
</thead>
{foreach from=$groups item=group}
	<tr class="{cycle values="row1,row2"}">
	<td width="10">
	<form action="/admin/User" method="post" onsubmit="return !formSubmit(this);">
	<input type="hidden" name="section" value="Permission" />
	<input type="hidden" name="perm_action" value="view" />
	<input type="hidden" name="group" value="{$group->getId()}" />
   	<input type="image" src="/images/admin/{if ($selected == $group)}yellow{else}orange{/if}-bullet.gif" />
	</form>
	</td>
	<td>{$group->getName()}</td>
	</tr>
{/foreach}
</table>

<table class="admin_list" cellspacing="0" cellpadding="0" border="0">
<thead>
	<tr>
		<th valign="center">Group</th>
		<th valign="center">Item</th>
{foreach from=$perms item=name}
		<th valign="center">{$name}</th>
{/foreach}
	</tr>
</thead>
{foreach from=$classes item=class}
	<tr class="{cycle values="row1,row2"}">
	<td>{$selected->getName()}</td>
	<td>{$class}</td>
  {foreach from=$perms item=name key=key}
      <td>
     	{if $permHandler->exists($class, $key)}
		{assign var=value value=$permHandler->hasPerm($selected, $class, $key)}
		<form action="/admin/User" method="post" onsubmit="return !ui.formSubmit(this);" style="float: left;">
		  <input type="hidden" name="section" value="Permission" />
		  <input type="hidden" name="perm_action" value="toggle" />
		  <input type="hidden" name="group" value="{$selected->getId()}" />
		  <input type="hidden" name="class" value="{$class}">
		  <input type="hidden" name="key" value="{$key}">
		  <input type="image" src="/images/admin/{if $value}tick{else}cross{/if}.png" />
		</form>
	    {/if}
	  </td>
  {/foreach}
  </tr>
{/foreach}
</table>
