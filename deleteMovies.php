<?php
$name=isset($_GET['name']) ? $_GET['name'] : die('ERROR: ID not found'); //Aquire the ID

include 'connection.php'; //Init the connection

try { 
    $query = "DELETE FROM country WHERE name = :name"; // Insert your DELETE query here
    $stmt = $con->prepare($query);
    $stmt->bindParam(':name', $name); //Binding the ID for the query

    if($stmt->execute()){
        header('Location: movies.php'); //Redirecting back to the main page
    }else{
        die('Could not remove'); //Something went wrong
    }
}

catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>