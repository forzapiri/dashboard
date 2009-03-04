<form method="POST" action="/Store/Search/">
	<input type="hidden" name="action" value="Simple">
	<input type="text" name="searchPhrase" value="{$searchPhrase}">
	<input type="submit" name="btnSubmit" value="Search">
	<a href="/Store/Search&action=Advanced">Advanced Search</a>
</form>
{if $btnSubmit}
	{include file="SearchResults.tpl"}
{/if}