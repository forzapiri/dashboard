{foreach from=$menus item=curmenu name='loop'}
<h2>{$curmenu->getName()}</h2>
{assign var=n value=$smarty.foreach.loop.iteration}
{* Templates({$templates|@count}) *}
<div id="buttons">
	<ul id="primary">
		<li><a href="/admin/Menu&amp;section=menuitem&action=addedit&n={$n}&menuitem_menu_id={$curmenu->getId()}" title="Create Menu Item" class="create">Create Menu Item</a></li>
{if $norex || ($n>$minimumNumber && $templates|@count>1)}
		<li><a href="/admin/Menu&amp;section=menutype&action=addedit&n={$n}&menutype_id={$curmenu->getId()}" class="other" title="Edit Menu Template">Menu Template</a></li>
{/if}
{if $n>$minimumNumber}
		<li class="plain norexui_delete"><a class="delete" href="/admin/Menu&amp;section=menutype&action=deleteMenu&menutype_id={$curmenu->getId()}"
		    title="Delete the entire menu?">Delete Entire Menu</a></li>
		</li>
{/if}
	</ul>
</div>



{assign var=menu value=$curmenu->getMenu()->getRoots()}
<table border="0" cellspacing="0" cellpadding="0" class="admin_list">
<thead>
	<tr>
		<th valign="center">Menu Item *</th>
		<th valign="center">Links To</th>
		<th valign="center">Opens In</th>
		<th valign="center" style="width: 60px">Active? **</th>
		<th valign="center">Actions ***</th> 
	</tr>
</thead>
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
		<li><a href="/admin/Menu&amp;section=menutype&action=addedit" class="create" title="Create New Menu">Create Entirely New Menu</a></li>
	</ul>
</div>
<div style="clear: both;">{nbsp}</div>
{/if}
