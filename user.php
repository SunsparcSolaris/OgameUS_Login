<?php
session_start();
$role = $_SESSION['role'];
if ( $role !== "ga" ) {
echo "<center><h1>Access Denied</h1><br /><h3>Redirecting to login page...</h3></center>";
echo "<meta http-equiv='refresh' content='5,url=index.php'>";
exit();
}
?>
<html>
<head>
<title>OgameUS Script Portal</title>
</head>

<body>

<center><h1>OgameUS Script Portal</h1></center>
<center><a href="portal.php">Back To Portal Page</a></center>
<?php
$usr = $_SESSION['usr'];
echo " <center><h3>$usr - Add/Remove Users</h3</center> ";
?>
<br />
<center>
<form action="#" method="post" name="addform">
<fieldset>
<legend>Add User:</legend>
Username: <input type="text" size="16" name="addusr" />
Password: <input type="text" size="16" name="addpass" />
Role: <select name="role"><option value=""></option>
	<option value="go">GO</option>
	<option value="sgo">SGO</option>
</select>
Uni Pages: <input type="text" size="16" name="unipages" />
<input type="submit" name="submit" value="Add User" />
<input type="hidden" name="submitbutton" value="addusrbutton" />

<br />
<h4>Enter Uni Pages as comma separated numbers. Example: 1,102,105 etc.</h4>
</fieldset>
</form>
</center>
<br />
<center>
<form action="#" method="post" name="removeform">
<fieldset>
<legend>Remove User:</legend>
Coming Soon...
</fieldset>
</form>
</center>

<br />
<center>
<?php
require 'table.php';
?>
</center>

</body>
</html>


<?php

require 'connect.php';
require './lib/password.php';
$actiontype = $_POST['submitbutton'];
$usr = mysql_real_escape_string($_POST['addusr']);
$pass = mysql_real_escape_string($_POST['addpass']);
$encpass = password_hash($pass, PASSWORD_BCRYPT);
$role = $_POST['role'];
$unipages = mysql_real_escape_string($_POST['unipages']);

if ( $actiontype == "addusrbutton" && password_verify($pass, $encpass)) {
mysql_query("INSERT INTO login SET usr = '{$usr}', pass = '{$encpass}', role = '{$role}', uni = '{$unipages}'");
}
elseif (!password_verify($pass, $encpass)) {
echo "Invalid";
}
else {
echo "";
}
?>
