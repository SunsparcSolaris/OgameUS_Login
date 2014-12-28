<?php
require 'connect.php';
$result = mysql_query("SELECT id,usr,role,dt,locked,uni,email FROM login");

echo "<table border='1'>
<tr>
<th>ID</th>
<th>User</th>
<th>Role</th>
<th>LastLogin</th>
<th>Uni</th>
<th>Locked</th>
<th>Email</th>
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
if ($timetotal >= "432000") {
  echo "<td class=\"red\">" . $row['dt'] . "</td>";
}
elseif ($timetotal <= "432000") {
  echo "<td class=\"green\">" . $row['dt'] . "</td>";
}
  echo "<td>" . $row['uni'] . "</td>";
if ($row['locked'] == "yes") {
  echo "<td style=\"background-color:red\">" . $row['locked'] . "</td>";
}
elseif ($row['locked'] == "no") {
  echo "<td>" . $row['locked'] . "</td>";
}
  echo "<td>" . $row['email'] . "</td>";
  echo "</tr>";
  }
echo "</table>";
echo "<a style=\"margin-left:45%;\" href=\"user.php\">Refresh Table</a>";
echo "<center class=\"right\">Red: More than 5 days since last login.<br />
Green: Less than  2 days since last login.
</center>";
mysql_close($con);
?>
