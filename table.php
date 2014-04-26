<?php
require 'connect.php';
$result = mysql_query("SELECT id,usr,role,dt,locked,uni FROM login");

echo "<table border='1'>
<tr>
<th>ID</th>
<th>User</th>
<th>Role</th>
<th>LastLogin</th>
<th>Uni</th>
<th>Locked</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
$dt = $row['dt'];
$dt = strtotime($dt);
$ctime = time();
$timetotal = $ctime - $dt;
  echo "<tr>";
  echo "<td>" . $row['id'] . "</td>";
  echo "<td>" . $row['usr'] . "</td>";
  echo "<td>" . $row['role'] . "</td>";
if ($timetotal >= "259200") {
  echo "<td class=\"red\">" . $row['dt'] . "</td>";
}
elseif ($timetotal <= "259200") {
  echo "<td class=\"green\">" . $row['dt'] . "</td>";
}
  echo "<td>" . $row['uni'] . "</td>";
if ($row['locked'] == "yes") {
  echo "<td style=\"background-color:red\">" . $row['locked'] . "</td>";
}
elseif ($row['locked'] == "no") {
  echo "<td>" . $row['locked'] . "</td>";
}
  echo "</tr>";
  }
echo "</table>";
echo "<br />";
echo "<br \/>";
echo "<a href=\"user.php\">Refresh Table</a>";
echo "<center class=\"right\">Red > 3 days since last login.<br />
Green < 2 days since last login.
</center>";
mysql_close($con);
?>
