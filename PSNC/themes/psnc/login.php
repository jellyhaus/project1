<div id="login">

	<form name="loginform" id="loginform" action="/wp-login.php" method="post">
	
	<label>Login:
		<input type="text" name="log" id="log" value="" size="20" tabindex="1">
	</label>
	
	<label>Password: 
		<input type="password" name="pwd" id="pwd" value="" size="20" tabindex="2">
	</label>
	
	<p class="submit">
		<input type="submit" name="submit" id="submit" value="Login &raquo;" tabindex="3">
		<input type="hidden" name="redirect_to" value="wp-admin/">
	</p>
	
	</form>

</div>
<!-- /login -->