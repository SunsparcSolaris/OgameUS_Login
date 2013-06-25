<?php
$con=mysqli_connect("localhost","root","meagan","ogameusers");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$result = mysqli_query($con,"SELECT id,usr,role,uni FROM login");

echo "<table border='1'>
<tr>
<th>ID</th>
<th>User</th>
<th>Role</th>
<th>Uni</th>
</tr>";

while($row = mysqli_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['id'] . "</td>";
  echo "<td>" . $row['usr'] . "</td>";
  echo "<td>" . $row['role'] . "</td>";
  echo "<td>" . $row['uni'] . "</td>";
  echo "</tr>";
  }
echo "</table>";

mysqli_close($con);
?>
