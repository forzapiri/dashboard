<div class="notice">Please be careful with changing the contents of the code below. Improper editing of the site template 
could cause your website to not display, or cause it to not look as you'd like it to.</div>


<script language="javascript" type="text/javascript" src="/modules/Templater/js/edit_area/edit_area_full.js"></script>
<script language="javascript" type="text/javascript">
{literal}
editAreaLoader.init({
	id : "editor"		// textarea id
	,syntax: "html"			// syntax to be uses for highgliting
	,start_highlight: true		// to display with highlight mode on start-up
	,font_size: 9
});
{/literal}
</script>

<form action="/admin/Templater" method="post">
<div class="editor_details">
<a href="/admin/Templater&action=otherinterface">Click here to micro manage the templates</a><br /><br />
<input type="hidden" name="template_id" value="{$curtemplate->getId()}" /> 
<input type="submit" name="save" value="Save" />
<br /><br />

<h1>Details</h1>
<p>
<strong>Module:</strong> {$curtemplate->getModuleName()}<br />
<strong>Path:</strong> {$curtemplate->getPath()}<br />
<strong>Last Modified:</strong> {$curtemplate->getTimestamp()|date_format:"%D %l:%M %p"}

<h3>Revisions</h3>
<select name="revision" id="revision">
{foreach from=$curtemplate->getRevisions() item=template}
	<option value="{$template->getId()}"{if $template->getId() == $curtemplate->getId()} selected="selected"{/if}>{$template->getId()}: {$template->getTimestamp()}</option>
{/foreach}
</select>
<input type="submit" name="switch_revision" value="Edit This Revision" />
</p>

<br /><br /><hr /><br />

<select name="template" id="template">
{foreach from=$templates item=template}
	<option value="{$template->getId()}"{if $template->getId() == $curtemplate->getId()} selected="selected"{/if}>{$template->getModuleName()}: {$template->getPath()}</option>
{/foreach}
</select>
<input type="submit" name="switch_template" value="Edit This Template" />
</div>

<textarea class="editor" id="editor" name="editor">
{$curtemplate->getData()}
</textarea>

</form>