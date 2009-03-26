<form action="/admin/Mail" method="post"> 
<input type="hidden" name="section" value="content">
<input type="hidden" name="action" value="queue">
<input type="hidden" name="mailcontent_id" value="{$content->getId()}">
<table id="mailclient" style="width: 600px; background-color: #c3d9ff;">
<tr>
	<td class="title">To:</td>
	<td class="input"><p>
	<select name="maillist_id">
		{foreach from=$lists item=list}
		<option value="{$list->getId()}">{$list->getName()}</option>
		{/foreach}
	</select>
	<strong class="help">Please choose a mailing list to send to</strong>
	</p></td>
</tr>
<tr>
	<td class="title">Subject:</td>
	<td class="input"><p>{$content->getSubject()}</p></td>
</tr>
<tr>
	<td class="title">From:</td>
	<td class="input"><p>{$content->getFromName()} &lt;{$content->getFromAddress()}&gt;</p></td>
</tr>
<tr>
	<td></td>
	<td><input type="submit" name="mail_send_submit" value="Send to Mailing List" /></td>
</tr>
<tr>
<td colspan="2" class="content"><iframe src="/admin/Mail&amp;section=content&amp;action=iframe_preview&amp;mailcontent_mail_id={$content->getId()}" /></td>
</tr>

</table>
</form>