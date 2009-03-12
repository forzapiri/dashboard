<form method="POST" action="{$module->getModulePrefix()}Search/">
	<input type="hidden" name="action" value="Simple">
	<input type="text" name="searchPhrase" value="{$searchPhrase}">
	<input type="submit" name="btnSubmit" value="Search">
	<a href="{$module->getModulePrefix()}Search&action=Advanced">Advanced Search</a>
</form>
{if $btnSubmit}
	{include file="SearchResults.tpl"}
{/if}