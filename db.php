<?php
$user = "user";
$password = "pass";
$hostname = "localhost"; 
$dbhandle = mysql_connect($hostname, $user, $password) 
 or die("Unable to connect to MySQL");
//echo "Connected to MySQL<br>";
$selected = mysql_select_db("bf4log",$dbhandle) 
  or die("Could not select database");