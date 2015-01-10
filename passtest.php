<html>
<head>
<title>Pass Test</title>

<body>

<br />
<br />
<br />
<center>
<form action="#" method="post" name="testform">
String: <input type="text" name="string" /><br />
Hash: <input type="text" name="hash" /><br />
<input type="submit" name="submit" value="Compare" />
</form>
</center>

</body>
</html>

<?php

require 'lib/password.php';
$string = $_POST['string'];
$subhash = $_POST['hash'];


if ( password_verify($string, $subhash)) {
echo "Yes";
}
else {
echo "No";
}

?>
