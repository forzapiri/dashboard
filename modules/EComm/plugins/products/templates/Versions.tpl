{if $versions}
	<div id="versionWrap">
	{foreach from=$versions item=test}
		<b>Version - {$test->getVersion()}</b>
		<hr />
		<div class="versionBody">
			{$test->getHistory()}
		</div>
		
	{/foreach}
	</div>
{else}
	<b>No Version Information</b>
{/if}