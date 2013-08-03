<?php

session_start();
$loggedin = $_SESSION['loggedin'];
$role = $_SESSION['role'];
$usr = $_SESSION['usr'];
if ($_SESSION['uni'] !== "all") {
$uni = explode(',', $_SESSION['uni']);
}
elseif ($_SESSION['uni'] == "all") {
$uni = "all";
}

if ($loggedin !== "1") {
   print " <center><h1>You must log in first.<br />Redirecting to Login page...</h1></center> ";
	echo "<meta http-equiv='refresh' content='3,url=index.php'>";
	exit();
}
?>

<html>
<head>
<title>OgameUS Script Portal</title>
<link rel="stylesheet" type="text/css" href="design.css" />
</head>
<body class="portal">
<center><img src="img/portal-logo.png" alt="OgameUS Script Portal" /></center>
<br />
<div id="topbar">
<center>|
<a href="http://board.ogame.us" target="_blank">Board</a> |
<a href="http://www.ogame.us" target="_blank">Game</a> |
<a href="chgpass.php">Change Pass</a> |

<?php
if ($role == "ga" ) {
echo "<a href=\"user.php\">Manage Users</a> |";
}
?>

</center>

<?php
$currentunis = "1,101,102,103,104,105,106,107,108,109,110,111,113";
$currentunis = explode(',', $currentunis);
if ( $role == 'ga' ) {
echo " <br /> <center><h3> $usr - Game Admin</h3></center></div> ";
echo "<div id=\"maindiv\">";
$dir = './output';
$files = preg_grep('/^([^.])/', scandir($dir));
foreach(array_slice($files,2) as $indfile) {
echo "<center><li><a href=\"output/$indfile\">$indfile</a></li>";
}
}


elseif ( $role == 'sgo' ) {
echo " <br /><center><h3> $usr - Super Game Operator</h3></center> </div>";
echo "<div id=\"maindiv\">";
if ($uni == "all") {
$dir = './output';
$files = preg_grep('/^([^.])/', scandir($dir));
foreach(array_slice($files,2) as $indfile) {
echo "<center><li><a href=\"output/$indfile\">$indfile</a></li></center>";
}
}
elseif($uni !== "all") {
require 'connect.php';
foreach($uni as $page) {
echo " <center><a href=\"output/output.uni$page.php\" >Universe $page</a>";
$sql = mysql_query("SELECT run_end FROM ogameus_".$page.".runs ORDER BY run_id DESC LIMIT 1");
$fetch = mysql_fetch_array($sql);
echo " - ";
echo $fetch['run_end'];
}
}
}


elseif ( $role == 'go' ) {
require 'connect.php';
echo "<br /><center><h3>$usr - Game Operator</h3></center> </div>";
echo "<div id=\"maindiv\">";
if (!empty($uni)) {
foreach($uni as $page) {
echo " <center><a href=\"output/output.uni$page.php\" >Universe $page</a>";
$sql = mysql_query("SELECT run_end FROM ogameus_".$page.".runs ORDER BY run_id DESC LIMIT 1");
$fetch = mysql_fetch_array($sql);
echo " - ";
echo $fetch['run_end'];
}
}

else {
echo " <center>No universes to display.</center> ";
}
}


else {
print " <center><h1>Access Denied</h1></center> ";
}
mysql_close($con);
?>
</div>
<div id="sidebar">
GO Links: <br />
<ul>
<li><a href="https://coma.gameforge.com/index.php" target="_blank">COMA Tool</a></li>
<li><a href="http://tools.ogamecentral.com/trade-calculator" target="_blank">Trade Calculator</a></li>
<li><a href="https://game.mx.gfsrv.net/" target="_blank">Webmail</a></li>
<li><a href="http://kelder.dnsalias.net:58520/CrazyTom/" target="_blank">CrazyTom Tools</a></li>
<li><a href="http://www.miraclesalad.com/webtools/md5.php" target="_blank">MD5 Hash</a></li>
</ul>
</div>
<div id="rightbar">
GO Guides:
<ul>
<li><a href="http://board.ogame.us/board174-news/board175-the-game/51895-new-ogame-us-rules-effective-17th-sept-2012/" target="_blank">OgameUS Rules</a></li>
<li><a href="http://board.ogame.us/board27-team-section/board247-go-lair/board254-go-tools/42933-new-go-guide/" target="_blank">GO Guide</a></li>
<li><a href="http://www.infuza.com/en/ogame.us" target="_blank">Ogame Stats</a></li>
</ul>
</div>

<br />
<br />
<div id="logout">
<center>
<h3><a href="logout.php">Log Out</a></h3>
</center>
<br />
<center><a href="../hesk">Pushing Script Support</a></center>
</div>
</body>
</html>

