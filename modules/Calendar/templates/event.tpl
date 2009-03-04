<h1>{$event->get('event_name')}</h1>
<h6>{$event->get('event_start')|date_format:"%B %e, %Y"}</h6>
{$event->get('event_description')}

<p>Location: {$event->get('event_location')|default:"<em>None specified</em>"}<br />
Start: {$event->get('event_start')|date_format:"%B %e, %Y at %H:%M"}<br />
End: {$event->get('event_end')|date_format:"%B %e, %Y at %H:%M"}</p>