<?php

require 'connect.php';
require 'lib/password.php';

$_POST['usr'] = mysql_real_escape_string($_POST['usr']);
$password = mysql_real_escape_string($_POST['pass']);

$filter = mysql_query("SELECT usr,pass,role,uni,forcepass,locked FROM login WHERE usr='{$_POST['usr']}'");

$hash = password_hash($password, PASSWORD_BCRYPT);

$row = mysql_fetch_array($filter);
if ( $row['locked'] == "yes" ) {
echo "<br /><center><h1 style=\"color:red\">Account is locked. Please contact Admin.</h1></center>";
exit();
}

if ( $row['usr'] != ""  && password_verify($password, $row['pass']) ) {
session_start();
$_SESSION['loggedin'] = "1";
$_SESSION['role'] = $row['role'];
$_SESSION['uni'] = $row['uni'];
$_SESSION['usr'] = $row['usr'];
$_SESSION['forcepass'] = $row['forcepass'];
$date = date("Y-m-d H:i:s");
mysql_query("UPDATE login SET dt = '{$date}' WHERE usr = '{$_SESSION['usr']}'");
if ($_SESSION['forcepass'] == "0") {
header('Location: portal.php');
}
elseif ($_SESSION['forcepass'] == "1") {
header('Location: forcepass.php');
}
}
else {
$_SESSION['loggedin'] = "0";
header('Location: portal.php');
}

?>
