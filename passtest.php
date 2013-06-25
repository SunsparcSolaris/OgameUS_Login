<html>
<head>
<title>Pass Test</title>

<body>

<br />
<br />
<br />
<center>
<form action="#" method="post" name="testform">
Encrypt: <input type="text" name="pass" />
<input type="submit" name="submit" value="Submit" />
</form>
</center>

</body>
</html>

<?php

require 'lib/password.php';
$password = $_POST['pass'];

$hash = password_hash($password, PASSWORD_BCRYPT);

echo " $hash ";

?>
