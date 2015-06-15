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
   echo "<html><head><link rel=\"stylesheet\" type=\"text/css\" href=\"design.css\" /></head>
<br /><br /><br /<br /><br /><br /><br /><br />
<body class=\"portal\"> <center><h1>You must log in first.<br />Redirecting to Login page...</h1></center></body></html> ";
	echo "<meta http-equiv='refresh' content='4,url=index.php'>";
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

</div><div id="maindiv">

<?php

$currentunis = file_get_contents('./currentunis');
$currentunis = explode(',', $currentunis);
if ( $role == 'ga' ) {
if (!empty($uni)) {
echo "<center><table border=\"0\" class=\"padded\"><th>Universe</th><th>Last Run (EST)</th><span class=\"td\">";
foreach($currentunis as $page) {
echo "<tr><td><center><a href=\"output/output.uni$page.php\" >Universe $page</a></td>";
$sql = mysql_query("SELECT run_end FROM ogameus_".$page.".runs ORDER BY run_id DESC LIMIT 1");
$fetch = mysql_fetch_array($sql);
$fetch = $fetch['run_end'];
echo "<td>$fetch</td></tr>";
}
}
}

elseif ( $role == 'sgo' ) {
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
}
}

/*
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
}
}
}
*/

elseif ( $role == 'go' ) {
if (!empty($uni)) {
echo "<center><table border=\"0\" class=\"padded\"><th>Universe</th><th>Last Run</th><span class=\"td\">";
foreach($uni as $page) {
echo "<tr><td><center><a href=\"output/output.uni$page.php\" >Universe $page</a></td>";
$sql = mysql_query("SELECT run_end FROM ogameus_".$page.".runs ORDER BY run_id DESC LIMIT 1");
$fetch = mysql_fetch_array($sql);
$fetch = $fetch['run_end'];
echo "<td>$fetch</td></tr>";
}
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

</span></center></table>
</div>

<div id="sidebar">
GO Links: <br />
<ul>
<?php include 'links1.php';
?>
</ul>
</div>
<div id="rightbar">
GO Guides:
<ul>
<?php include 'links1.php';
?>
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

