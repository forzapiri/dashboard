
<table class="calendar" border="0" cellpadding="1" cellspacing="1">
  <tr>
    <th class="month" colspan="7">
      {$month_name}&nbsp;{$year}
    </th>
  </tr>
  <tr>
    <td class="prev-month" colspan="3">
      <a href="{$prev_month_end|date_format:$url_format}">
        {$prev_month_abbrev}
      </a>
    </td>
    <td></td>
    <td class="next-month" colspan="3">
      <a href="{$next_month_begin|date_format:$url_format}">
        {$next_month_abbrev}
      </a>
    </td>
  </tr>
  <tr>
  {section name="day_of_week" loop=$day_of_week_abbrevs}
    <th class="day-of-week">{$day_of_week_abbrevs[day_of_week]}</th>
  {/section}
  </tr>
  {section name="row" loop=$calendar}
    <tr class="days">
      {section name="col" loop=$calendar[row]}
        {assign var="date" value=$calendar[row][col]}
        {if $date == $selected_date}
        {assign var=event_today value=false}
        	{foreach from=$events item=event}
              	{if $event->getEventStart()|date_format:"%e" == $date|date_format:"%e"}
              	{assign var=event_today value=true}
              	{/if}
             {/foreach}
          <td class="selected-day active{if $event_today} event_today{/if}" valign="top" id="date_{$date}"><span class="day_number">{$date|date_format:"%e"}</span>
          {foreach from=$events item=event}
              	{if $event->getEventStart()|date_format:"%e" == $date|date_format:"%e"}
              	<div class="cal_event" id="event_{$event->getId()}"><a href="/calendar/{$event->get('calendar_id')}/{$event->getId()}-{$event->getEventName()|urlify}">{$event->getEventName()}</a></div>
              	{/if}
              {/foreach}
          </td>
        {elseif $date|date_format:"%m" == $month}
        	{assign var=event_today value=false}
        	{foreach from=$events item=event}
              	{if $event->getEventStart()|date_format:"%e" == $date|date_format:"%e"}
              	{assign var=event_today value=true}
              	{/if}
             {/foreach}
          <td class="day active{if $event_today} event_today{/if}" valign="top" id="date_{$date}">
            <a href="{$date|date_format:$url_format}" class="day_number">
              <span class="day_number">{$date|date_format:"%e"}</span>
            </a>
            {foreach from=$events item=event}
              	{if $event->getEventStart()|date_format:"%e" == $date|date_format:"%e"}
              	<div class="cal_event" id="event_{$event->getId()}"><a href="/calendar/{$event->get('calendar_id')}/{$event->getId()}-{$event->getEventName()|urlify}">{$event->getEventName()}</a></div>
              	{/if}
              {/foreach}
          </td>
        {else}
          <td class="non-month-day"></td>
        {/if}
      {/section}
    </tr>
  {/section}
  <tr>
    <td class="today" colspan="7">
      {if $today_url != ""}
        <a href="{$today_url}">Today</a>
      {else}
        Today
      {/if}
    </td>
  </tr>
</table>