{if $testimonials}
	<div id="testimonialWrap">
	{foreach from=$testimonials item=test}
		<h4>{$test->getTitle()}</h4>
		<hr />
		<div class="testimonialbody">
			{$test->getBody()}
		</div>
		
	{/foreach}
	</div>
{else}
	<h4>No Testimonials</h4>
{/if}