{include file="admin/subnav.tpl"}

<p>In this interface you can create, edit and send out mail content.</p>

<div id="buttons">
	<ul id="primary">
		<li><a class="create" href="/admin/Mail&amp;section=content&amp;action=addedit" title="Create New Mail Content">Create New Content</a></li>
	</ul>
</div>

	<table border="0" cellspacing="0" cellpadding="0" class="admin_list">

		<tr>
				<th valign="center">Subject</th>

				<th valign="center">Last Modified</th>
				<th valign="center">Actions</th>
		</tr>
		{foreach from=$contents item=content}
				<tr class="{cycle values="row1,row2"}">
			<td>
				{$content->getSubject()}
			</td>
			<td style="width: 100px;">
				{$content->getLastMod()|date_format}
			<td class="center" style="width: 150px;">
				<form action="/admin/Mail" method="post" class="norexui_addedit" style="float: left;">
					<input type="hidden" name="section" value="content" />
					<input type="hidden" name="action" value="addedit" />
					<input type="hidden" name="mailcontent_mail_id" value="{$content->getId()}" />
					<input type="image" src="/images/admin/pencil.gif" />
				</form>

				<form action="/admin/Mail" class="delete" method="post" style="float: left;" class="norexui_delete">
					<input type="hidden" name="section" value="content" />
					<input type="hidden" name="action" value="delete" />
					<input type="hidden" name="mailcontent_mail_id" value="{$content->getId()}" />
					<input type="image" src="/images/admin/cross.gif" />
				</form>
				
				<form action="/admin/Mail" method="post" style="float: right;" class="norexui_addedit">
					<input type="hidden" name="section" value="content" />
					<input type="hidden" name="action" value="send" />
					<input type="hidden" name="mailcontent_mail_id" value="{$content->getId()}" />
					<input type="image" src="/modules/Mail/images/sendtolist.png" />
				</form>
			</td>

		</tr>
		{/foreach}
			</table>