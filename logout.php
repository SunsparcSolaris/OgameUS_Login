<?php
session_start();
unset($_SESSION);
session_destroy();
session_write_close();
print " <center><h1>Logged out!</h1><br /> <h3>Redirecting to Login page...</h3></center> ";
        echo "<meta http-equiv='refresh' content='2,url=index.php'>";
die;
?>
