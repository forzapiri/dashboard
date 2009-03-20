{if $curgallery && $curgallery->getGalleryImages()}
	<h3>{$curgallery->get('name')}</h3>
	{foreach from=$curgallery->getGalleryImages() item=image}
		<div class="gallery_thumb">
		<a href="{$image->get('file')->getImageLink()}" rel="lightbox[{$curgallery->get('name')}]">{$image->get('file')->getImgTag('w=150&h=131')}</a>
		</div>
	{/foreach}
{/if}

{if $galleries}
	<p>Please choose a gallery below...</p><br />
	{counter assign='count' start=0 print=0}
	<table width="700" border="0" cellspacing="0" cellpadding="0" class="galleries">
	{foreach from=$galleries item=gallery}
		{if $count is div by 4}
			{if $count!=0}
				</tr>
			{/if}
			<tr align="center" valign="middle" class="galleryTitle">
		{/if}
		<td>
		{if $gallery->getFirstImage()}
			<a href="/gallery/{$gallery->get('id')}-{$gallery->get('name')|urlify}">
			{$gallery->get('thumbnail')->getImgTag()}
			</a><br>
		{/if}
		<a href="/gallery/{$gallery->get('id')}-{$gallery->get('name')|urlify}">
		{$gallery->get('name')}</a></td>
		{counter assign='count' print=0}
	{/foreach}
</tr></table>
{/if}