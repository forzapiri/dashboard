<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$cmsName} - Website Management</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="stylesheet" href="/css/admin_menu.css,/css/admin_tabs.css,/css/admin.css{if $css.norm|@count > 0}{foreach from=$css.norm item=cssUrl},{$cssUrl}{/foreach}{/if}" type="text/css" />
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

<div id="sitewrap">
	
	<div id="headerHolder">
		<div id="headerTitle"><a href="/admin/"><img src="/images/admin/norex_logo.png" alt="Norex" title="Norex" /></a></div>
		<div id="logout"><a href="/user/logout">LOGOUT</a> | <a href="/" title="Return to Public Site">BACK TO SITE</a></div>
		<div id="nav">{menu admin=true}</div>
	</div>

	<div id="content">
		<div id="contentTopTd"></div>
		<div id="contentTd">
			<h2><span style="color:#000;">norex://</span> {$module_title}</h2>
			<div id="messages"></div>
			<div id="module_content">{module class=$module admin=true}</div>
		</div>
		<div id="contentBottomTd"></div>
	</div>
	
	<div id="footer">
		<p>&copy; 2009 by <a href="http://www.norex.ca" title="Norex Core Web Development">Norex Core Web Development</a></p>
		<p>Codename Beeblebrox</p>
	</div>

</div>

</body>
</html>
