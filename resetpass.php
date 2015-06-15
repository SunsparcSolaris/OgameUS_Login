<html>
<head>
<title>OgameUS Script Portal | Change Password</title>
<link rel="stylesheet" type="text/css" href="design.css" />
</head>
<body class="chgpass">

<center><img src="img/portal-logo.png" alt="OgameUS Script Portal" /></center>
<center><a href="index.php">Back to Login Page</a><br /><center>
</center>
<div>
<center>
<form action="#" method="post">
<p>Please enter the email address associated with your Ogame.US Portal account.</p>
<label>Email Address:</label> <input type="text" size="24" name="email" /><br /><br />
<input type="submit" name="submitbutton" value="Reset Password" />
<input type="hidden" name="resetbutton" value="resetbutton" />
</form>
</center>
</div>
</body>
</html>


<?php

/*Set up db connection*/
require 'connect.php';
require 'lib/password.php';
require 'rdmpwgen.php';

$email = strtolower($_POST['email']);
$actiontype = $_POST['resetbutton'];

if ($actiontype == "resetbutton") {

$row = mysql_fetch_array(mysql_query("SELECT usr,email FROM login WHERE email='{$email}'"));
$usr = $row['usr'];
if ( $email == $row['email'] && count($row) > 0 ) {
$rdmpass = rand_string(5);
$newpass = password_hash($rdmpass, PASSWORD_BCRYPT);
mysql_query("UPDATE login SET pass = '{$newpass}', forcepass = 1 WHERE email = '{$email}'");
echo "<br /><br /><center>Please check your Ogame.US email for more instructions.</center> ";
mail($email,"Ogame.US Portal Password Reset","Hello, $usr, \r\n Your Ogame.US Portal Account Password has been reset. \r\n \r\n New Password: $rdmpass \r\n Regards","From: PinkFloyd@ogame.us");
}

mysql_close($con);
}
else {
echo "";
}

?>
