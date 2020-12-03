<?php
$pid=isset($_GET['pid']) ? $_GET['pid'] : die('ERROR: ID not found'); //Aquire the ID
print_r($_GET['n']);
$n=isset($_GET['n']) ? $_GET['n'] :  '';
if($n == 1){
    header("Location: users.php?error={'userDelete'}");
    die('bruh');
}
include 'connection.php'; //Init the connection
$cid = strrev(substr(strrev($pid), 1));
try { 
    $query = "DELETE FROM profile WHERE pid = :pid"; // Insert your DELETE query here
    $stmt = $con->prepare($query);
    $stmt->bindParam(':pid', $pid); //Binding the ID for the query

    $query2 = "DELETE FROM watchlist WHERE pid = :pid"; // Insert your DELETE query here
    $stmt2 = $con->prepare($query2);
    $stmt2->bindParam(':pid', $pid); //Binding the ID for the query

    $query3 = "DELETE FROM rating WHERE pid = :pid";
    $stmt3 = $con->prepare($query3);
    $stmt3->bindParam(':pid', $pid);

    $query4 = "DELETE FROM owns_profile WHERE pid = :pid";
    $stmt4 = $con->prepare($query4);
    $stmt4->bindParam(':pid', $pid);

    if($stmt4->execute() && $stmt3->execute() && $stmt2->execute() && $stmt->execute()){
        header('Location: users.php');
    }
}
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>