<h3>{$report->getSubject()}</h3>

{assign var=width value=$report->getCompletedPercent()}
				{math equation="x - 2" x=$width assign=width}
				<div class="status">{if $width > 0}<img src="/modules/Mail/images/bar.png" style="height: 12px; width: {$width}px;" />{/if}</div>
				{$report->getCompletedPercent()|string_format:"%d"}% Complete Sending ({$report->getSentCount()} / {$report->getListDistribution()})

<br /><br />
<table width="500" class="admin_list">
<tr>
	<th>Reciever</th>
	<th>View Date/Time</th>
	<th>Mail Client</th>
</tr>

{foreach from=$report->getViews() item=view}
<tr>
	<td>{$view->getUser()}</td>
	<td>{$view->getTimestamp()|date_format:"%B %e, %Y %I:%M %p"}</td>
	<td><img src="{$view->getBrowserIcon()}" alt="{$view->getBrowser()->Browser}" /></td>
</tr>
{/foreach}
</table>