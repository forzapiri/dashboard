<form method="post" action="{$smarty.server.REQUEST_URI}">
<fieldset class="hidden">
<ol>

<li><label for="username" class="element">Username:</label><div class="element"><input type="text" id="username" name="username" /></div></li>
<li><label for="password" class="element">Password:</label><div class="element"><input type="password" id="password" name="password" /></div></li>
<li><label for="submit" class="element">&nbsp;</label><div class="element"><input value="Login" id="doLogin" name="doLogin" type="submit" /></div></li>

</ol>
</fieldset>
</form>

<p><a href="/user/signup">Create an Account</a></p>
