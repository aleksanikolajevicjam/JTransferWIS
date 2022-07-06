<?php if(isset($error)){ echo $error;}?>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
<h1>Login</h1>
<label for="username">User name:</label>
    <input type="text" id="username" name="username" autocomplete="off">
<label for="password">Password:</label>
    <input type="password" id="password" name="password" autocomplete="off">
<br/>
<br/>    
<button type="submit" name="Login" value="submit">Ok</button>
</form>
