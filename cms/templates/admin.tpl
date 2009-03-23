<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{siteconfig get="CMSname"} - Website Management</title>
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
<div id="container">
<div id="header">
  <div id="top_nav"><a class="logout" href="/user/logout">Sign Out</a> <a class="return_to_site" href="/">Return to Site</a></div>
  <div id="logo">{siteconfig get="CMSname"} <a href="/">&larr; Visit site</a></div>
</div>
<div id="header_shadow">{nbsp}</div>


<div id="left_menu">{menu admin=true}</div>

<div id="main_window">

<div id='module_title'>
	  <h1>{$module_title}{if $emulating} - {$emulating}'s View{/if}</h1>
  </div>
  
  <div id="content">
  	<div id="module_content">{module class=$module admin=true}</div>
  </div>
</div>

<div id="footer">
 	<p> 
 	<span style="float: right;">Memory Usage: {siteconfig info="memory"} |
 	Render Time: {siteconfig info="render_time"} seconds</span>
 	&copy; {$smarty.now|date_format:"%Y"} by <a href="http://www.norex.ca" title="Norex Core Web Development">Norex Core Web Development</a>
 	</p>
</div>

</div>
</body>
</html>
