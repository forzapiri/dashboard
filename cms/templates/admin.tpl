<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{siteconfig get="CMSname"} - Website Management</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript" src="/core/tinymce/jscripts/tiny_mce/tiny_mce_gzip.js"></script>
<script>{literal}
tinyMCE_GZ.init({
		plugins : 'safari,inlinepopups,autosave,spellchecker,paste,media,fullscreen,tabfocus,showhide',
		themes : 'advanced,dashboard',
		languages : 'en',
		disk_cache : false,
		debug : true
	});
{/literal}</script>
{stylesheets}
{javascripts}
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
