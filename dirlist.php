<html>
<head>
<title>Directory Listing</title>
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
</head>
<body>

<?php
$dir = './output';
$files = scandir($dir);
foreach($files as $ind_file){
?>
<li><a href="<?php echo $dir."/".$ind_file;?>"><?php echo $ind_file;?></li>
<?php
}
?>
</ul> 

</body>
</html>
