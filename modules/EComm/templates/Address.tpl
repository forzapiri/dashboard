{if $address}
	{$address->getStreetAddress()}
	{if $address->getStreetAddress()}<br />{/if}
	
	{$address->getCity()}
	{if $address->getCity()},{/if}
	
	{$address->getStateName()}
	{if $address->getStateName()},{/if}
	
	{$address->getPostalCode()}
	{if $address->getCity() || $address->getStateName() || $address->getPostalCode()}<br />{/if}
	
	{$address->getCountryName()}
	{if $address->getCountryName()}<br />{/if}
{/if}
<a href="#" onclick="return !addressEdit('{$adr_type}');">Edit</a>
