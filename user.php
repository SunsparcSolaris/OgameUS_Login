<?php
session_start();
$role = $_SESSION['role'];
if ( $role !== "ga" && $role !== "sgo" ) {
echo "<center><h1>Access Denied</h1><br /><h3>Redirecting to login page...</h3></center>";
echo "<meta http-equiv='refresh' content='5,url=index.php'>";
exit();
}
?>
<html>
<head>
<title>OgameUS Script Portal</title>
<link rel="stylesheet" type="text/css" href="design.css" />
<link rel="stylesheet" href="jquery-ui.css">
  <script src="jquery-1.10.2.js"></script>
  <script src="jquery-ui.js"></script>
  <script>
 $(function() {
    $( "#accordion" ).accordion({
      collapsible: true,
	active: false
    });
  });
  </script>
<style type="text/css">
fieldset {
    width: 50%;
    float: left;
}
legend {
    margin: 0 5%;
}
td.red {background-color:red;}
td.yellow {background-color:yellow;}
td.green {background-color:green;}
center.right {float: right; margin-right:325px;}
</style>
</head>

<body class="user">

<center><img src="img/portal-logo.png" alt="OgameUS Script Portal" /></center>
<center><a href="portal.php">Back To Portal Page</a></center>
<?php
$usr = $_SESSION['usr'];
echo " <center><h3>$usr - Add/Remove Users</h3</center> ";
?>

<?php
if ( $role == "ga" ) {
?>
<div id="accordion">
<h3>Add User</h3>
<div>
<form action="#" method="post" name="addform">
Username: <input type="text" size="16" name="addusr" />
Password: <input type="text" size="16" name="addpass" /><br />
Role: <select name="role"><option value=""></option>
	<option value="go">GO</option>
	<option value="sgo">SGO</option>
</select>
Uni Pages: <input type="text" size="16" name="unipages" />
Email: <input type="text" size="16" name="email" />
<input type="submit" name="submit" value="Add User" />
<input type="hidden" name="submitbutton" value="addusrbutton" />

</form>
</div>

<h3>Edit User</h3>
<div>
<form action="#" method="post" name="editform">
<!-- Username: <input type="text" size="16" name="editusr" />*/ -->
Username: <select name="editselect">
<option value=""></option>
<?php
require 'connect.php';
$filter = mysql_query("SELECT usr FROM login");
while($row = mysql_fetch_array($filter))
{
echo "<option value=\"" . $row['usr'] . "\"> " . $row['usr'] . "</option>  ";
}
mysql_close($con);
?>
</select>
Choose which to change:
<input type="radio" name="editchoice" value="role" />Role
<input type="radio" name="editchoice" value="uni" />Uni <br />
Insert change: <input type="text" size="16" name="edittext" />
<input type="submit" name="submit" value="Edit User" />
<input type="hidden" name="submitbutton" value="editusrbutton" />
<br />
</form>
</div>

<h3>Remove User</h3>
<div>
<form action="#" method="post" name="removeform">
Type the Username you want to remove. (Use the table):<br />
<center>User: <input type="text" name="rmusr" />
<input type="submit" name="submit" value="Remove User" />
<input type="hidden" name="submitbutton" value="rmusrbutton" />
</form>
</div>
</div>
</center>
<?php }
else {
echo '';
}
?>

<center>
</center>
<?php
require 'table.php';
?>

</body>
</html>


<?php

$actiontype = $_POST['submitbutton'];

if ($actiontype == "addusrbutton") {
require 'connect.php';
require './lib/password.php';
$usr = mysql_real_escape_string($_POST['addusr']);
$pass = mysql_real_escape_string($_POST['addpass']);
$encpass = password_hash($pass, PASSWORD_BCRYPT);
$role = $_POST['role'];
$unipages = mysql_real_escape_string($_POST['unipages']);
$email = mysql_real_escape_string($_POST['email']);

if (password_verify($pass, $encpass)) {
mysql_query("INSERT INTO login SET usr = '{$usr}', pass = '{$encpass}', forcepass = '1', locked = 'no', role = '{$role}', uni = '{$unipages}', email = '{$email}'");
echo "User added! User will be required to change password upon first login!";
}
elseif (!password_verify($pass, $encpass)) {
echo "Invalid";
}
else {
echo "";
}
}


if ($actiontype == "rmusrbutton") {
require 'connect.php';
$rmusr = $_POST['rmusr'];
$filter = mysql_query("SELECT usr,role FROM login WHERE usr='{$rmusr}'");
$query = mysql_fetch_array($filter);

if ($query['role'] == "ga") {
echo "You cannot remove another GA!";
exit();
}
elseif ($rmusr == $query['usr']) {
mysql_query("DELETE FROM login WHERE usr='{$rmusr}' LIMIT 1");
echo "User removed!";
}
else {
echo "Username not found in database!";
}
}


if ($actiontype = "editusrbutton") {
require 'connect.php';
$editusr = $_POST['editselect'];
$edittext = $_POST['edittext'];
$editchoice = $_POST['editchoice'];
$filter = mysql_query("SELECT usr,role,uni FROM login WHERE usr='{$editusr}'");
$query = mysql_fetch_array($filter);

if ($query['role'] == "ga") {
echo "<br />You cannot edit another GA!";
exit();
}
elseif ($editusr == $query['usr'] && $editchoice == "role") {
mysql_query("UPDATE login SET role = '{$edittext}' WHERE usr = '{$editusr}'");
echo "<br />User role updated!";
}
elseif ($editusr == $query['usr'] && $editchoice == "uni") {
mysql_query("UPDATE login SET uni = '{$edittext}', locked = 'no' WHERE usr = '{$editusr}'");
echo "<br />User uni pages updated!";
}
}

mysql_close($con);
?>

