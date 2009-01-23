<h1>Other <b>News</b></h1>
{assign var=blockcount value=0}
{foreach from=$blocks item=block}
<div class="event">
	<h3>{$block->getTitle()}</h3>
	{assign var=blockcount value=$blockcount+1}
	{$block->getContent()}
	
</div>
<div class="hr"> </div>
{/foreach}
