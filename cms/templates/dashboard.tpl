<p class="dashboard">We understand that good online marketing comes from being able to effectively communicate with your customers. 
We understand that this means being able to demonstrate how your unique competitive advantages are well aligned 
with your target markets needs. In addition to traditional internet marketing techniques, our creative team and 
web experts based out of Halifax, Nova Scotia has the unique advantage of being web-centric. This means that 
unlike most other internet marketing firms, we see the web as the primary marketing tool for your company while 
additional tools such as print and other media forms play important supporting roles.</p>

<div class="info-box">
<h2>At a Glance</h2>
<ul>
{foreach from=$modules item=module}
{if $module->page}
	<li>
	<h3>{$module->name}</h3>
	<ul>
	{if $module->page->heading|@count > 0}
	{foreach from=$module->page->heading item=heading key=key}
		<li>
		<span class="data">{$module->page->getItems($key)|@count}</span>
		<span class="title"><a href="/admin/{$module->name}&amp;section={$key}">{$key}s</a></span>
		</li>
	{/foreach}
	{else}
		{assign value=$module->page->pointer var=pointer}
		<li><span class="data">{$module->page->getItems()|@count}</span>
		<span class="title">
		<a href="/admin/{$module->name}&amp;section={$pointer}">{if $module->page->names[$pointer]}{$module->page->names[$pointer]}{else}{$pointer}{/if}s
		</a></span>
		</li>
	{/if}
	</ul>
	</li>
{/if}
{/foreach}
</ul>
<p>There are currently <strong>{$modules|@count}</strong> modules installed</p>
</div>

<div class="info-box">
<h2>Site Configuration</h2>
<ul>
<li><h3>Site Name</h3><p>{siteconfig get="CMSname"}</p></li>
</ul>
</div>

<div class="info-box">
<h2>Site Configuration</h2>
<ul>
<li><h3>Site Name</h3><p>{siteconfig get="CMSname"}</p></li>
</ul>
</div>

