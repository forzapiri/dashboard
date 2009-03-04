{include file="CartDetails.tpl" page="Display"}
{if $loginFail}
	<font color="red">Invalid username or password. You have to be logged in to checkout your cart.</font>
{/if}
<h1>Checkout</h1>

<h2>Returning Customer</h2>
{if !$loggedIn}
	<p>Please enter your username and password below.</p>
	<form method="post" action="/Store/Cart/&action=Checkout">
		<fieldset class="hidden">
			<label for="username" class="element">Username:</label><div class="element"><input type="text" id="username" name="username" /></div>
			<label for="password" class="element">Password:</label><div class="element"><input type="password" id="password" name="password" /></div>
			<label for="submit" class="element">&nbsp;</label><div class="element"><input value="Login" id="doLogin" name="doLogin" type="submit" /></div>
		</fieldset>
	</form>
{else}
	<form method="post" action="/Store/Cart/&action=Checkout">
		<fieldset class="hidden">
			<input type="submit" name="btnSubmit" value="Checkout" />
			<input type="button" name="btnLogout" value="Logout" onclick="javascript:document.location='/user/logout';" />
		</fieldset>
	</form>
{/if}
	
<h2>New Customer</h2>
{if $userExist}
	<font color="red">Check the fields. Username may already exist!</font>
{/if}
{$user_form->display()}