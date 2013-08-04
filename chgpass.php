<?php
/*Start the session*/
session_start();

/*Check if user is logged in. If not, deny and redirect. */
if ($_SESSION['loggedin'] !== "1") {
   print " <center><h1>Access Denied.<br />Redirecting to Login page...</h1></center> ";
        echo "<meta http-equiv='refresh' content='3,url=index.php'>";
	unset($_SESSION);
	session_destroy();
	session_write_close();
        exit();
}
?>

<html>
<head>
<title>OgameUS Script Portal | Change Password</title>
<link rel="stylesheet" type="text/css" href="design.css" />
</head>
<body class="chgpass">

<center><img src="img/portal-logo.png" alt="OgameUS Script Portal" /></center>
<center><a href="portal.php">Back to Portal Page</a><br /><center>
<?php
$usr = $_SESSION['usr'];
echo " <h3>$usr - Change Password</h3> ";
?>
</center>
<div id="chgpassdiv">
<center>
<form action="#" method="post">
<label>Old Password:</label> <input type="password" size="16" name="oldpass" /><br />
<label>New Password:</label> <input type="password" size="16" name="newpass" /><br />
<label>Confirm New: </label> <input type="password" size="16" name="confnewpass" /><br /><br />
<input type="hidden" name="chgpass" value="chgpass" />
<input type="submit" name="chgpassbutton" value="Change Password" />
</form>
</center>
</div>
<center><h3><a href="logout.php">Log Out</a></h3></center>
</body>
</html>


<?php

/*Set up db connection*/
require 'connect.php';

require 'lib/password.php';

/*Change POST variables to actual variables, escape the input*/
$oldpass = mysql_real_escape_string($_POST['oldpass']);
$newpass = mysql_real_escape_string($_POST['newpass']);
$confnewpass = mysql_real_escape_string($_POST['confnewpass']);

/*Select info from the database. usr must match session user and pass must match the provided oldpass*/
$row = mysql_fetch_array(mysql_query("SELECT pass FROM login WHERE usr='{$_SESSION['usr']}'"));

if ( password_verify($oldpass, $row['pass']) && $newpass == $confnewpass && count($row) > 0 ) {
$hash = password_hash($newpass, PASSWORD_BCRYPT);
mysql_query("UPDATE login SET pass = '{$hash}' WHERE usr = '{$_SESSION['usr']}'");
echo " <center>Password Updated. You may return to the Portal Page.</center> ";
}
elseif ( !password_verify($oldpass, $row['pass']) && $_POST['chgpassbutton'] == "Change Password" ) {
echo " <center>Old password does not match the database, try again!</center> ";
}
elseif ( $newpass !== $confnewpass && $_POST['chgpassbutton'] == "Change Password" ) {
echo " <center>New passwords do not match, try again!</center> ";
}
elseif ( $_POST['chgpassbutton'] !== "Change Password" ) {
exit();
}

mysql_close($con);
?>
