<p>This page is for your Google Analytics code. If you don't have a Google Analytics Account, sign up <a href="#">HERE!</a></p>
{if $scripts}
	<table border="0" cellspacing="0" cellpadding="0" class="adminList" style="clear: both; float: left;">
		<tr>
				<th valign="center">Title *</th>
				<th valign="center" style="width:150px;">Actions ***</th>
		</tr>
		
			{foreach from=$scripts item=script}

		<tr class="{cycle values="row1,row2"}">
			<td>
				Your Analytics Script
			</td>
			<td class="center">
				<form action="/admin/Analytics" method="post" style="float: left;">
					<input type="hidden" name="section" value="addedit" />
					<input type="hidden" name="analytics_id" value="{$script->getId()}" />
					<input type="image" src="/images/admin/pencil.gif" />
				</form>
				<form action="/admin/Analytics" class="delete" method="post" style="float: left;" onsubmit="return !deleteConfirm(this, 'script');">
					<input type="hidden" name="section" value="delete" />
					<input type="hidden" name="analytics_id" value="{$script->getId()}" />
					<input type="image" src="/images/admin/page_delete.gif" />
				</form>
			</td>

		</tr>
{/foreach}
	
		<tr>
		<td colspan="3" class="legend" id="help" style="text-align: left;" valign="top"></td>
		<td colspan="2" class="legend">
{strip}
			{$module->trigger('showMenuFooter')}{/strip}
		</td>
	</tr>
	</table>
{else}

<div class="roundcont">
   <div class="roundtop">
	 <img src="/images/admin/noAsset_tl.png" alt="" 
	 width="20" height="20" class="corner" 
	 style="display: none" />
   </div>

   <p>No Analytics Scripts Added. Would you like to <a href="/admin/Analytics&amp;section=addedit">make one</a>?</p>
  
   <div class="roundbottom">
	 <img src="/images/admin/noAsset_bl.png" alt="" 
	 width="20" height="20" class="corner" 
	 style="display: none" />
   </div>
</div>	

{/if}