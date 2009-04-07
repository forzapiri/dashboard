<?php
function doConditionalGet($etag, $lastModified)
{
	header("Last-Modified: $lastModified");
	header("ETag: \"{$etag}\"");
		
	$if_none_match = isset($_SERVER['HTTP_IF_NONE_MATCH']) ?
		stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) : 
		false;
	
	$if_modified_since = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ?
		stripslashes($_SERVER['HTTP_IF_MODIFIED_SINCE']) :
		false;
	
	if (!$if_modified_since && !$if_none_match)		return;
	
	if ($if_none_match && $if_none_match != $etag && $if_none_match != '"' . $etag . '"')
		return; // etag is there but doesn't match
	
	if ($if_modified_since && $if_modified_since != $lastModified)
		return; // if-modified-since is there but doesn't match
	
	// Nothing has changed since their last request - serve a 304 and exit
	header('HTTP/1.1 304 Not Modified');
	exit();
} // doConditionalGet()

$file			= '/files/' . preg_replace('/^(s?f|ht)tps?:\/\/[^\/]+/i', '', (string) $_GET['file']);
define('DOCUMENT_ROOT',			$_SERVER['DOCUMENT_ROOT']);
$docRoot	= preg_replace('/\/$/', '', DOCUMENT_ROOT);

// Replace trailing filename with 'public'
$publicFile = preg_replace('@/[^/]*$@', '/public', $docRoot . $file);
$permitted = file_exists($publicFile);

if (!$permitted)
{
	// For now, just check that the user is authenticated and is in the Administrator group
	require_once ('../include/Site.php');
	$u = @$_SESSION['authenticated_user'];
	$permitted = $u && ($u->hasPerm('CMS', 'admin') || $u->hasPerm('CMS','view'));
}

if (!$permitted)
{
	error_log ($publicFile);
	header('HTTP/1.1 401 Unauthorized');
	echo 'Error: Permission violation: ' . $docRoot . $file;
	exit();
}
$file = "$docRoot/$file";
$size	= GetImageSize("$file");
$mime	= $size['mime'];
$data	= file_get_contents("$file");
$lastModifiedString	= gmdate('D, d M Y H:i:s', filemtime($file)) . ' GMT';
$etag				= md5($data);
// doConditionalGet($etag, $lastModifiedString);
header("Content-type: $mime");
header('Content-Length: ' . strlen($data));
echo $data;
exit();
