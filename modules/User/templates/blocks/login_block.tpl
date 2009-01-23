<div id="loginBlock">
<h2>Login</h2>
{if !$user}
{if $smarty.post.username || $smarty.post.password}
<p class="error">Invalid username/password</p>
{/if}

<form method="post" id="userLoginForm" action="/user/login" onsubmit="return !loginSubmit(this);">
<p>Username: <input type="text" id="username" name="username" value="" /><br />
Password: <input type="password" id="password" name="password" /><br /></p>

<input value="Login" id="doLogin" name="doLogin" type="submit" /> 
</form>

<p><a href="/user/signup">Register</a></p>

{else}
<p>You are logged in as {$user->getUsername()}</p>
{if $user->hasPerm('admin')}
<p><a href="/admin/Content">Administration</a></p>
{/if}
<p><a href="/user/logout" onclick="return !logoutSubmit();">Logout</a></p>
{/if}
</div>