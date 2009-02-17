<tr class="{cycle values="row1,row2"}" id="{$item->getId()}">
		<td>
			<div class="indent" style="width: {math equation="(x-1) * 28" x=$item->depth}px;">{nbsp}</div>
			<div class="sort_buttons">
				{if !$item->bottom}
					<form action="/admin/Menu" method="post" style="display: inline;" onsubmit="return !formSubmit(this);">
						<input type="hidden" name="section" value="menuitem" />
						<input type="hidden" name="action" value="move" />
						<input type="hidden" name="menuitem_id" value="{$item->getId()}" />
						<input type="hidden" name="direction" value="down" />
						<input type="image" src="/images/admin/arrow_down.gif" alt="Move Item Down" />
					</form>
				{else}
					<img src="/images/spacer.gif" width="10px" />
				{/if}

				{if !$item->top}
					<form action="/admin/Menu" method="post" style="display: inline;" onsubmit="return !formSubmit(this);">
						<input type="hidden" name="section" value="menuitem" />
						<input type="hidden" name="action" value="move" />
						<input type="hidden" name="direction" value="up" />
						<input type="hidden" name="menuitem_id" value="{$item->getId()}" />
						<input type="image" src="/images/admin/arrow_up.gif" alt="Move Item Up" />
					</form>
				{else}
					<img src="/images/spacer.gif" width="10px" />
				{/if}
			</div>
			<div class="menuItemName">{$item->getDisplay()}</div>
		</td>
		<td>{$item->getModule()}: <a href="{$item->getLinkTarget()}">{$item->getLinkTarget()}</a></td>
		<td class="opensIn">{if $item->getTarget() == "same"}Same Window{else}New Window{/if}</td>
		<td style="text-align: center;">
			<form action="/admin/Menu" method="post" style="display: inline;" onsubmit="return !formSubmit(this);">
				<input type="hidden" name="section" value="menuitem" />
				<input type="hidden" name="action" value="toggle" />
				<input type="hidden" name="menuitem_id" value="{$item->getId()}" />
				{if $item->getStatus() == 1}
				<input type="image" src="/images/admin/tick.gif" alt="Move Item Up" />
				{else}
				<input type="image" src="/images/admin/cross.gif" alt="Move Item Up" />
				{/if}
			</form>
		</td>
		<td class="actions">
			<form method="POST" action="/admin/Menu" class="norexui_addedit" style="float: left;">
				<input type="hidden" name="menuitem_id" value="{$item->getId()}" />
				<input type="hidden" name="n" value="{$n}" />
				<input type="hidden" name="section" value="menuitem" />
				<input type="hidden" name="action" value="addedit" />
				<input type="image" name="edit" id="edit" value="edit" src="/images/admin/pencil.gif" />
			</form>
 			<form method="POST" action="/admin/Menu" class="norexui_delete" style="float: left;">
				<input type="hidden" name="menuitem_id" value="{$item->getId()}" />
				<input type="hidden" name="action" value="delete" />
				<input type="hidden" name="section" value="menuitem" />
				<input type="image" name="delete" id="delete" value="delete" src="/images/admin/page_delete.gif" />
			</form>
		</td>
</tr>
{foreach from=$item->children item=child}
	{include file="admin/menu_item_row.tpl" item=$child}
{/foreach}