{if $gallery && $gallery->getGalleryVideos()}
	<h2>{$gallery->get('name')}</h2>
	{foreach from=$gallery->getGalleryVideos() item=video}	
		<div class="video_wrapper">
		<h3>{$video->get('name')}</h3>
		{$video->get('embed_code')}
		<p>{$video->get('description')}</p>
		</div>
	{/foreach}
{/if}