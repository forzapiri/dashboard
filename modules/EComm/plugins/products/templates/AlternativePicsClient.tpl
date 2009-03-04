<img src="/images/image.php?id={$product->getImage()}&cliph=40" onMouseOver="displayAltPic('/images/image.php?id={$product->getImage()}&cliph=140')">
{foreach from=$altPics item=pic}
	<img src="/images/image.php?id={$pic->getImage()}&cliph=40" onMouseOver="displayAltPic('/images/image.php?id={$pic->getImage()}&cliph=140')">
{/foreach}
<br/>