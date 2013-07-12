<?php
$con = mysql_connect("localhost","ogameusportal","ogameusgo");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("ogameusers",$con);
?>
