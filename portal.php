<?php

session_start();
$loggedin = $_SESSION['loggedin'];
$role = $_SESSION['role'];
$usr = $_SESSION['usr'];
$uni = explode(',', $_SESSION['uni']);

/*foreach($uni as $page) {
echo " <a href=\"output/output.uni$page.html\" >Universe $page</a> <br />";
}
*/

if ($loggedin !== "1") {
   print " <center><h1>You must log in first.<br />Redirecting to Login page...</h1></center> ";
	echo "<meta http-equiv='refresh' content='3,url=index.php'>";
	exit();
}
?>

<html>
<head>
<title>OgameUS Script Portal</title>
</head>
<body>
<center><h1>OgameUS Script Portal</h1></center>
<center>| 
<a href="http://board.ogame.us" target="_blank">Board</a> | 
<a href="http://www.ogame.us" target="_blank">Game</a> | 


<?php
if ( $role == 'ga' ) {
echo " <a href=\"user.php\">Add/Remove User</a> | <a href=\"chgpass.php\">Change Pass</a> | </center> <br /> <center><h3> $usr - Game Admin</h3></center> ";

$dir = './output';
$files = preg_grep('/^([^.])/', scandir($dir));

foreach(array_slice($files,2) as $indfile) {
echo "<center><li><a href=\"output/$indfile\">$indfile</a></li></center>";
}
}
elseif ( $role == 'sgo' ) {
echo " <a href=\"chgpass.php\">Change Pass</a> | </center><br /><center><h3> $usr - Super Game Operator</h3></center> ";
foreach($uni as $page) {
echo " <center><a href=\"output/output.uni$page.php\" >Universe $page</a> <br /></center>";
}
}
elseif ( $role == 'go' ) {
echo " <a href=\"chgpass.php\">Change Pass</a> | </center></center><br /><center><h3>$usr - Game Operator</h3></center> ";
if (empty($uni)) {
foreach($uni as $page) {
echo " <center><a href=\"output/output.uni$page.php\" >Universe $page</a> <br /></center>";
}
}
else {
echo " <center>No universes to display.</center> ";
}
}
else {
print " <center><h1>Access Denied</h1></center> ";
}

?>

<br />
<br />
<center>
<h3><a href="logout.php">Log Out</a></h3>
</center>
</body>
</html>

