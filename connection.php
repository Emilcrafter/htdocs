<?php
//Here is the information the needed for connection
$host = "psql-dd1368-ht20.sys.kth.se"; //The database you want to connect to
$db_name = "efranz"; //Your username. If you want to look at a simple example for the main page, use a username with the Mondial datbase
$username = "efranz"; //Your username
$password = "E8DcqKGFgKFh"; //The password you retrieved from your folder in Putty

try {
    $con = new PDO("pgsql:host={$host};dbname={$db_name}", $username, $password);
}
//In case of error
catch(PDOException $exception){
    echo "Connection error: " . $exception->getMessage();
}
?>