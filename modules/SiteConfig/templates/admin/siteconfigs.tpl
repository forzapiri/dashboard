{if $programmer}
<p style="width: 100%; text-align: right;"><a href="/admin/SiteConfig&amp;action=addedit" class="create">Create new configuration variable</a></p>
{/if}

<table border="0" cellspacing="0" cellpadding="0" class="admin_list">
<thead>
	<tr>
{if $programmer}
		<th valign="center">Name</th>
		<th valign="center">Type</th>
		<th valign="center">Sort</th>
{/if}
		<th valign="center">Description</th>
		<th valign="center">Value(s)</th>
        <th></th>
	</tr>
</thead>
<tbody>
	{foreach from=$siteconfigs item=siteconfig}
	<tr class="{cycle values="row1,row2"}">
{if $programmer}
		<td>{$siteconfig->getName(true)}</td>
		<td>{$siteconfig->getRawType()|truncate:30}</td>
		<td>{$siteconfig->getSort()}</td>
		<td>{$siteconfig->getDescription()|truncate:30}</td>
		<td>{$siteconfig->displayString()|truncate:30}</td>
{else}
		<td>{$siteconfig->getDescription()}</td>
		<td>{$siteconfig->displayString()}</td>
{/if}

		<td class="actions">
{if $programmer}
		<form action="/admin/SiteConfig" method="post" class="norexui_toggle" style="float: left;">
			<input type="hidden" name="action" value="toggle" />
			<input type="hidden" name="NOREX" value="1" />
			<input type="hidden" name="siteconfig_id" value="{$siteconfig->getId()}" />
			<input type="image" src="/images/admin/{if $siteconfig->getEditable() == '1'}tick{else}cross{/if}.gif" />
		</form>
{/if}
		<form action="/admin/SiteConfig" method="post" style="float: left;">
			<input type="hidden" name="action" value="addedit" />
			<input type="hidden" name="siteconfig_id" value="{$siteconfig->getId()}" />
			<input type="image" src="/images/admin/pencil.gif" />
		</form>
{if $programmer}
		<form action="/admin/SiteConfig" method="post" onsubmit="return !deleteConfirm({$siteconfig->getId()});" style="float: left;">
            <input type="hidden" name="action" value="delete" />
			<input type="hidden" name="siteconfig_id" value="{$siteconfig->getId()}" />
			<input type="image" src="/images/admin/page_delete.gif" /></td>
		</form>
{/if}
		</td>
	</tr>
	{/foreach}
</tbody>
</table>
