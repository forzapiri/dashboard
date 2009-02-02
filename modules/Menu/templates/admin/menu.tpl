{foreach from=$menus item=curmenu name='loop'}
{assign var=n value=$smarty.foreach.loop.iteration}
{* Templates({$templates|@count}) *}
<div id="buttons">
	<ul id="primary">
		<li><a href="/admin/Menu&amp;section=menuitem&action=addedit&n={$n}&menuitem_menu_id={$curmenu->getId()}" title="Create Menu Item">Create Menu Item</a></li>
{if $norex || ($n>$minimumNumber && $templates|@count>1)}
		<li><a href="/admin/Menu&amp;section=menutype&action=addedit&n={$n}&menutype_id={$curmenu->getId()}" title="Edit Menu Template">Menu Template</a></li>
{/if}
{if $n>$minimumNumber}
		<li class="plain norexui_delete"><a href="/admin/Menu&amp;section=menutype&action=deleteMenu&menutype_id={$curmenu->getId()}"
		    title="Delete the entire menu?">Delete Entire Menu</a></li>
		</li>
{/if}
	</ul>
</div>

<h2 style="float: left;">{$curmenu->getName()}</h2>

{assign var=menu value=$curmenu->getMenu()->getRoots()}
<table border="0" cellspacing="0" cellpadding="0" class="adminList" style="clear: both; float: left;">
	<tr>
		<th valign="center">Menu Item *</th>
		<th valign="center">Links To</th>
		<th valign="center">Opens In</th>
		<th valign="center" style="width: 60px">Active? **</th>
		<th valign="center">Actions ***</th> 
	</tr>
<tbody id="menuTable">
{foreach from=$menu item=item}
	{include file="admin/menu_item_row.tpl"}
{/foreach}
</tbody>
</table>
<div style="clear: both;"><br /><br /></div>
{/foreach}

{if $n < $maximumNumber}
<div id="buttons">
	<ul id="primary">
		<li><a href="/admin/Menu&amp;section=menutype&action=addedit" title="Create New Menu">Create Entirely New Menu</a></li>
	</ul>
</div>
<div style="clear: both;">{nbsp}</div>
{/if}
