<html>
<head>
<title>BCRYPT Password Generator</title>
</head>

<body>
<center><h1>BCRYPT Password Generator</h1></center>
<br />
<br />
<center>
<form action="#" method="post">
<input type="text" size="24" name="pass" />
<input type="submit" name="submit" value="Generate" />
</form>
</center>
<br />
<br />
</body>
</html>

<?php

include 'password.php';


$hash = password_hash($_POST['pass'], PASSWORD_BCRYPT);
if (password_verify($_POST['pass'], $hash)) {
echo "<center>$hash</center>";
}
else {
echo "Invalid hash";
}

?>

