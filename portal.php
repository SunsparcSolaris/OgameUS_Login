<?php

require 'connect.php';

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
<p style="margin-left:75%;"><?php echo "<b>User: $usr - Role: "; echo strtoupper($role); echo "</b>" ?></p>
<center><img src="img/portal-logo.png" alt="OgameUS Script Portal" /></center>
<br />
<div id="topbar">
<center>
<a href="http://board.ogame.us" target="_blank">Board</a> |
<a href="http://www.ogame.us" target="_blank">Game</a> |
<a href="chgpass.php">Change Pass</a> |

<?php
if ($role == "ga" ) {
echo "<a href=\"user.php\">Manage Users</a> |";
}
elseif ($role == "sgo") {
echo "<a href=\"user.php\">Manage Users</a> |";
}
?>
&nbsp;<a href="https://www.bwmhost.us/hesk">Support</a> |
 <u>Status:<?php
    exec("ps aux | grep -i script_single | grep -v grep", $pids);
    if (count($pids) > 0) {
        print("<b style=\"color:limegreen; background-color:black;\">&nbsp;Running&nbsp;</b>");
    }
    else {
	print(" <b>Idle</b>");
	}
?>
</u></center><br />

<?php

$currentunis = file_get_contents('./currentunis');
$currentunis = explode(',', $currentunis);
if ( $role == 'ga' ) {
echo "</div><div id=\"maindiv\">";
if (!empty($uni)) {
echo "<center><table border=\"0\" class=\"padded\"><th>Universe</th><th>Last Run (EST)</th><span class=\"td\">";
foreach($currentunis as $page) {
echo "<tr><td><center><a href=\"output/output.uni$page.php\" >Universe $page</a></td>";
$sql = mysql_query("SELECT run_end FROM ogameus_".$page.".runs ORDER BY run_id DESC LIMIT 1");
$fetch = mysql_fetch_array($sql);
$fetch = $fetch['run_end'];
echo "<td>$fetch</td></tr>";
}
echo "</span></center></table>";
}
}


elseif ( $role == 'sgo' ) {
echo "</div><div id=\"maindiv\">";
if ($uni == "all") {
if (!empty($uni)) {
echo "<center><table border=\"0\" class=\"padded\"><th>Universe</th><th>Last Run</th><span class=\"td\">";
foreach($currentunis as $page) {
echo "<tr><td><center><a href=\"output/output.uni$page.php\" >Universe $page</a></td>";
$sql = mysql_query("SELECT run_end FROM ogameus_".$page.".runs ORDER BY run_id DESC LIMIT 1");
$fetch = mysql_fetch_array($sql);
$fetch = $fetch['run_end'];
echo "<td>$fetch</td></tr>";
}
echo "</span></center></table>";
}
}
elseif($uni !== "all") {
if (!empty($uni)) {
echo "<center><table border=\"0\" class=\"padded\"><th>Universe</th><th>Last Run</th><span class=\"td\">";
foreach($uni as $page) {
echo "<tr><td><center><a href=\"output/output.uni$page.php\" >Universe $page</a></td>";
$sql = mysql_query("SELECT run_end FROM ogameus_".$page.".runs ORDER BY run_id DESC LIMIT 1");
$fetch = mysql_fetch_array($sql);
$fetch = $fetch['run_end'];
echo "<td>$fetch</td></tr>";
}
echo "</span></center></table>";
}
}
}


elseif ( $role == 'go' ) {
echo "</div><div id=\"maindiv\">";
if (!empty($uni)) {
if (!empty($uni)) {
echo "<center><table border=\"0\" class=\"padded\"><th>Universe</th><th>Last Run</th><span class=\"td\">";
foreach($uni as $page) {
echo "<tr><td><center><a href=\"output/output.uni$page.php\" >Universe $page</a></td>";
$sql = mysql_query("SELECT run_end FROM ogameus_".$page.".runs ORDER BY run_id DESC LIMIT 1");
$fetch = mysql_fetch_array($sql);
$fetch = $fetch['run_end'];
echo "<td>$fetch</td></tr>";
}
echo "</span></center></table>";
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
<li><a href="https://game.mx.gfsrv.net/" target="_blank">Webmail</a></li>
<li><a href="http://ogame.ksenior.net/CrazyTom/" target="_blank">CrazyTom Tools</a></li>
<li><a href="http://www.miraclesalad.com/webtools/md5.php" target="_blank">MD5 Hash</a></li>
</ul>
</div>
<div id="rightbar">
GO Guides:
<ul>
<li><a href="http://board.ogame.us/board174-news/board175-the-game/51895-new-ogame-us-rules-effective-17th-sept-2012/" target="_blank">OgameUS Rules</a></li>
<li><a href="http://board.ogame.us/board27-team-section/board247-go-lair/board254-go-tools/42933-new-go-guide/" target="_blank">GO Guide</a></li>
<li><a href="http://board.ogame.us/board27-team-section/board247-go-lair/board254-go-tools/61973-at-note-guide/" target="_blank">AT Note Guide</a></li>
<li><a href="http://ogame.gamestats.org/?lang=us" target="_blank">Ogame Stats</a></li>
</ul>
</div>

<center>
<h3>News:</h3>
<?php $news = file_get_contents('./news');
print($news);
?>
</center>

<div id="logout">
<center>
<h3><a href="logout.php">Log Out</a></h3>

</center>
</div>
</body>
</html>

