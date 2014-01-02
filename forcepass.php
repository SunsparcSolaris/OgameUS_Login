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
<title>OgameUS Script Portal | Forced Password Change</title>
</head>
</body>

<center><h1>OgameUS Script Portal</h1><br />
<?php
$usr = $_SESSION['usr'];
echo " <h3>$usr - Forced Password Change</h3> ";
?>
</center>

<center>
<form action="#" method="post">
<fieldset>
<label>Old Password:</label> <input type="password" size="16" name="oldpass" /><br />
<label>New Password:</label> <input type="password" size="16" name="newpass" /><br />
<label>Confirm Pass: </label> <input type="password" size="16" name="confnewpass" /><br /><br />
<input type="hidden" name="chgpass" value="chgpass" />
<input type="submit" name="chgpassbutton" value="Change Password" />
</fieldset>
</form>
</center>

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
$dbpass = $row['pass'];

if ( password_verify($oldpass, $dbpass) && $newpass == $confnewpass && count($row) > 0 ) {
$newpass = password_hash($newpass, PASSWORD_BCRYPT);
mysql_query("UPDATE login SET pass = '{$newpass}', forcepass = 0 WHERE usr = '{$_SESSION['usr']}'");
echo " <center>Password Updated. Redirecting to the Portal Page.</center> ";
echo "<meta http-equiv='refresh' content='3,url=portal.php'>";
}
elseif ( !password_verify($oldpass, $dbpass) && $_POST['chgpassbutton'] == "Change Password" ) {
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
