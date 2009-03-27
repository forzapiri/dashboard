{include file="admin/subnav.tpl"}

	<table border="0" cellspacing="0" cellpadding="0" class="admin_list">

		<tr>
				<th valign="center">Subject</th>
				<th valign="center">Target List</th>
				<th valign="center">Date</th>
				<th valign="center">Status</th>
				<th valign="center">Actions</th>
		</tr>
		{foreach from=$reports item=report}
				<tr class="{cycle values="row1,row2"}">
			<td>
				{$report->getSubject()}
			</td>
			<td>
				{$report->getListName()}
			</td>
			<td>
				{$report->getDate()}
			</td>
			<td style="width: 150px;" class="report_status">
				{assign var=width value=$report->getCompletedPercent()}
				{math equation="x - 2" x=$width assign=width}
				<div class="status">{if $width > 0}<img src="/modules/Mail/images/bar.png" style="height: 12px; width: {$width}px;" />{/if}</div>
				{$report->getCompletedPercent()|string_format:"%d"}%
			</td>

			<td>
				<form action="/admin/Mail&amp;section=reports" method="post" class="norexui_addedit">
					<input type="hidden" name="action" value="view" />
					<input type="hidden" name="rid" value="{$report->getId()}" />
					<input type="image" src="/modules/Mail/images/report_go.png" />
				</form>
			</td>
		</tr>
		{/foreach}
			</table>