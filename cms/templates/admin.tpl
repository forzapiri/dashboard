<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$cmsName} - Website Management</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="stylesheet" href="/css/screen.css,/css/liquid.css,/css/admin_styles.css{if $css.norm|@count > 0}{foreach from=$css.norm item=cssUrl},{$cssUrl}{/foreach}{/if}" type="text/css" />
{if $css.print|@count > 0}
	<link rel="stylesheet" href="{foreach from=$css.print item=cssUrl}{$cssUrl}{if $css.print|@key < $css.print|@count},{/if}{/foreach}" type="text/css" media="print" />
{/if}
{if $css.screen|@count > 0}
	<link rel="stylesheet" href="{foreach from=$css.screen item=cssUrl}{$cssUrl}{if $css.screen|@key < $css.screen|@count},{/if}{/foreach}" type="text/css" media="screen" />
{/if}
<script type="text/javascript" src="/js/prototype.js,/js/scriptaculous.js{foreach from=$js item=jsUrl},{$jsUrl}{/foreach}"></script>
<script type="text/javascript" src="/core/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>

</head>
<body>

<div class='container' id='header'>
  <div class='column' id='logo'><a href="/admin/"><img src="/images/admin/norex_logo.png" /></a>
  </div>
  <div class='column last' id="nav">{menu admin=true}
  </div>
</div>


<div class='container' id="container_top">{nbsp}</div>

<div class='container' id='module_title'>
	  <h1><span class="fake_url">norex://</span> {$module_title}</h1>
  </div>
  
  <div class='container' id="content">
  	<div id="module_content">{module class=$module admin=true}</div>
  </div>
  
  <div class='container' id="container_bottom">{nbsp}</div>

<div class="container" id="footer">
  <div class='column span-24 last'>
 	<p>&copy; {$smarty.now|date_format:"%Y"} by <a href="http://www.norex.ca" title="Norex Core Web Development">Norex Core Web Development</a></p>
  </div>  
</div>

</body>
</html>
