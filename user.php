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
<input type="submit" name="addusrbutton" value="Add User" />

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
