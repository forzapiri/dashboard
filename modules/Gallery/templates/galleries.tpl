{if $galleries}
	<h1 style="clear: both;">Photo Galleries</h1>
	<p>Choose an album to view pictures</p>
	{foreach from=$galleries item=gallery}
	
	<div class="galHolder">
		<div class="gal">
			<a href="/gallery/{$gallery->get('id')}-{$gallery->get('name')|urlify}" title="{$gallery->get('name')}">
				{$gallery->get('thumbnail')->getImgTag('w=115&h=79')}
			</a>
		</div>
		<div class="galInfo">
			{$gallery->get('name')}
		</div>

		<div class="galFooter">
			&nbsp;
		</div>
	</div>
	{/foreach}
{/if}

{if $curgallery && $curgallery->getGalleryImages()}
	<h3 style="clear: both;">{$curgallery->get('name')}</h3>
	{foreach from=$curgallery->getGalleryImages() item=image}
	
	<div class="photoHolder">
		<div class="photo">
		<a href="{$image->get('file')->getImageLink('w=800&h=600')}" rel="lightbox[{$curgallery->get('name')}]" class="lbOn" title="{$image->get('title')}">
			{$image->get('file')->getImgTag('h=79&w=115')}
			</a>
		</div>
		<div class="photoInfo">
			{$image->get('title')}
		</div>
	
		<div class="photoFooter">
			&nbsp;
		</div>
	</div>
	{/foreach}
</tr></table>
{/if}