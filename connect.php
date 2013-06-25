<?php
$con = mysql_connect("localhost","root","meagan");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("ogameusers",$con);
?>
