<tr class="{cycle values="row1,row2"} {if $user->getActiveStatus() == 1}user_active{else}user_disabled{/if}">
		<td>{$user->getUsername()|escape}</td>
		<td>{$user->getName()|escape}</td>
		<td>{$user->getEmail()|escape}</td>
		<td>{$user->getGroup()->getName()}</td>
		<td>{if $user->getActiveStatus() == 1}
			Active
			{else}
			Disabled
			{/if}
		</td>
		<td class="actions">
			<form method="post" action="/admin/User" onsubmit="return !thickboxAddEdit(this);">
				<input type="hidden" name="user_aut_id" value="{$user->getId()}" />
				<input type="hidden" name="section" value="user" />
				<input type="hidden" name="action" value="addedit" />
				<input type="image" name="edit" value="edit" src="/images/admin/pencil.gif" />
			</form>
			<form method="post" action="/admin/User" onsubmit="return !deleteConfirm(this);">
				<input type="hidden" name="user_aut_id" value="{$user->getId()}" />
				<input type="hidden" name="section" value="user" />
				<input type="hidden" name="action" value="delete" />
				<input type="image" name="delete" value="delete" src="/images/admin/page_delete.gif" />
			</form>
		</td>
</tr>