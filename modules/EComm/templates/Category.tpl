<h2>Category: {$group->getName()}</h2>
<div class="CellInfo">
	<div class="CellInfoImage">
		{if $group->getImage()}
			<img border=0 src="/images/image.php?id={$group->getImage()}&cliph=140">
		{else}
			<img border=0 src="/modules/EComm/images/no_image.gif">
		{/if}
	</div>
	<div class="CellInfoDetails">
		{$group->getDetails()}
	</div>
</div>
{$group->displayBreadCrumb()} 
<br style="clear:both;"/>