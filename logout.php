<?php
session_start();
unset($_SESSION);
session_destroy();
session_write_close();
echo "<html><head><link rel=\"stylesheet\" type=\"text/css\" href=\"design.css\" /></head>
<br /><br /><br /><br /><body class=\"portal\"><center><h1>Logged out!</h1><br /> <h3>Redirecting to Login page...</h3></center></body></html> ";
        echo "<meta http-equiv='refresh' content='4,url=index.php'>";
die;
?>
