<html>
<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" bgcolor='#ffffff' >


{literal}
<STYLE>
 .headerTop { background-color:#FFCC66; border-top:0px solid #000000; border-bottom:1px solid #FFFFFF; text-align:center; }
 .adminText { font-size:10px; color:#996600; line-height:200%; font-family:verdana; text-decoration:none; }
 .headerBar { background-color:#FFFFFF; border-top:0px solid #333333; border-bottom:10px solid #FFFFFF; }
 .title { font-size:20px; font-weight:bold; color:#CC6600; font-family:arial; line-height:110%; }
 .subTitle { font-size:11px; font-weight:normal; color:#666666; font-style:italic; font-family:arial; }
 .defaultText { font-size:12px; color:#000000; line-height:150%; font-family:arial; }
 .footerRow { background-color:#FFFFCC; border-top:10px solid #FFFFFF; }
 .footerText { font-size:10px; color:#996600; line-height:100%; font-family:verdana; }
 a { color:#98d927; }
 td { padding-left:15px; padding-right:15px }
</STYLE>
{/literal}

<table width="100%" cellpadding="10" cellspacing="0" class="backgroundTable" bgcolor='#ffffff' >
<tr>
<td valign="top" align="center">

<table width="550" cellpadding="0" cellspacing="0">
 
<tr>
<td style="background-color:#FFFFFF;border-top:0px solid #333333;border-bottom:10px solid #FFFFFF;"><center><a href="http://www.greenparty.ns.ca"><IMG id="editableImg1" SRC="{$site}/images/gpNewsHeader.jpg" BORDER="0" title="Green Party of Nova Scotia"  alt="Green Party of Nova Scotia" align="center"></a></center></td>
</tr>

</table>

<table width="550" cellpadding="20" cellspacing="0" bgcolor="#FFFFFF">
<tr>
  <td bgcolor="#FFFFFF" valign="top" style="font-size:12px;color:#000000;line-height:150%;font-family:arial;">&nbsp;</td>
<td bgcolor="#FFFFFF" valign="top" style="font-size:12px;color:#000000;line-height:150%;font-family:arial;">
{$content->getContent()}</td>
<td bgcolor="#FFFFFF" valign="top" style="font-size:12px;color:#000000;line-height:150%;font-family:arial;">&nbsp;</td>
</tr>
<tr>
  <td style="background-color:#f0f8e3;border-top:10px solid #FFFFFF;" valign="top">&nbsp;</td>
<td style="background-color:#f0f8e3;border-top:10px solid #FFFFFF;" valign="top">
<span style="font-size:10px;color:#2b7b18;line-height:100%;font-family:verdana;">
To unsubscribe from this list, <a href="{$unsub}">click here</a>.<br />
<br />
Copyright (C) {$smarty.now|date_format:'%Y'} Green Party of Nova Scotia. All rights reserved.<br />
</span></td>
<td style="background-color:#f0f8e3;border-top:10px solid #FFFFFF;" valign="top">&nbsp;</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>
