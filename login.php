<?php

require 'connect.php';

$_POST['usr'] = mysql_real_escape_string($_POST['usr']);
$_POST['pass'] = mysql_real_escape_string($_POST['pass']);

$filter = mysql_query("SELECT usr,pass,role,uni,forcepass FROM login WHERE usr='{$_POST['usr']}' AND pass='".md5($_POST['pass'])."'");

$row = mysql_fetch_array($filter);
if ( $row['usr'] != ""  && $row['pass'] != "" ) {
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
