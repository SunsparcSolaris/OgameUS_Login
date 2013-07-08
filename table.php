<?php
$con=mysqli_connect("localhost","root","meagan","ogameusers");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$result = mysqli_query($con,"SELECT id,usr,role,runtime,dt,uni FROM login");

echo "<table border='1'>
<tr>
<th>ID</th>
<th>User</th>
<th>Role</th>
<th>LastLogin</th>
<th>Uni</th>
</tr>";

while($row = mysqli_fetch_array($result))
  {
$dt = $row['dt'];
$dt = strtotime($dt);
$ctime = time();
$timetotal = $ctime - $dt;
  echo "<tr>";
  echo "<td>" . $row['id'] . "</td>";
  echo "<td>" . $row['usr'] . "</td>";
  echo "<td>" . $row['role'] . "</td>";
if ($timetotal >= "172800" && $timetotal <= "259200") {
  echo "<td class=\"yellow\">" . $row['dt'] . "</td>";
}
elseif ($timetotal >= "259200") {
  echo "<td class=\"red\">" . $row['dt'] . "</td>";
}
elseif ($timetotal <= "172800") {
  echo "<td class=\"green\">" . $row['dt'] . "</td>";
}
  echo "<td>" . $row['uni'] . "</td>";
  echo "</tr>";
  }
echo "</table>";
echo "<center class=\"right\">Red > 3 days since last login.<br />
Yellow > 2 days since last login.<br />
Green < 2 days since last login.
</center>";
mysqli_close($con);
?>
