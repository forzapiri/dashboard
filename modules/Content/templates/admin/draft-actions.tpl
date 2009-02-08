<form action="/admin/Content" method="post" style="float: left;" class="norexui_addedit">
  <input type="hidden" name="section" value="ContentPage" />
  <input type="hidden" name="action" value="addedit" />
  <input type="hidden" name="id" value="{$id}" />
  <input type="image" src="/images/admin/pencil.png" />
</form>
<form action="/admin/Content" method="post" style="float: left;" class="norexui_draftdelete">
  <input type="hidden" name="section" value="ContentPage" />
  <input type="hidden" name="action" value="chunk_revertdrafts" />
  <input type="hidden" name="id" value="{$id}" />
  <input type="image" src="/images/admin/cross.png" />
</form>
<form action="/admin/Content" method="post" style="float: left;" class="norexui_draftlive">
  <input type="hidden" name="section" value="ContentPage" />
  <input type="hidden" name="action" value="chunk_makeactive" />
  <input type="hidden" name="id" value="{$id}" />
  <input type="image" src="/images/admin/arrow_turn_right.gif" />
</form>
<form action="/Content/" method="post" style="float: left;" class="norexui_draftlive">
  <input type="hidden" name="section" value="ContentPage" />
  <input type="hidden" name="action" value="viewdraft" />
  <input type="hidden" name="id" value="{$id}" />
  <input type="hidden" name="status" value="draft" />
  <input type="image" src="/images/admin/preview.gif" />
</form>
