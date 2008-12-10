<h1>Search - {$query}</h1>

{foreach from=$results item=result}
<br />
<div class="search_result">
<h3><a href="/content/{$result->parent->get('url_key')}">{$result->get('page_title')}</a></h3>
<p>{$result->get('content')|strip_tags|truncate}</p>
</div>
<div class="hr" style="width: 100%; background-repeat: repeat-x;"> </div>
{foreachelse}
<p>Sorry, no results found</p>
{/foreach}