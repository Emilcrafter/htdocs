<?php
$mid=isset($_GET['mid']) ? $_GET['mid'] : die('ERROR: ID not found'); //Aquire the ID

include 'connection.php'; //Init the connection

try { 
    $query1 = "DELETE FROM media WHERE mid = :mid"; // Insert your DELETE query here
    $stmt1 = $con->prepare($query1);
    $stmt1->bindParam(':mid', $mid); //Binding the ID for the query

    $query2 = "DELETE FROM series WHERE mid = :mid"; // Insert your DELETE query here
    $stmt2 = $con->prepare($query2);
    $stmt2->bindParam(':mid', $mid); //Binding the ID for the query

    $query3 = "DELETE FROM watchlist WHERE mid = :mid"; // Insert your DELETE query here
    $stmt3 = $con->prepare($query3);
    $stmt3->bindParam(':mid', $mid); //Binding the ID for the query

    $query4 = "DELETE FROM rating WHERE mid = :mid"; // Insert your DELETE query here
    $stmt4 = $con->prepare($query4);
    $stmt4->bindParam(':mid', $mid); //Binding the ID for the query

    $query5 = "DELETE FROM nationality WHERE mid = :mid"; // Insert your DELETE query here
    $stmt5 = $con->prepare($query5);
    $stmt5->bindParam(':mid', $mid); //Binding the ID for the query

    $query6 = "DELETE FROM mgenre WHERE mid = :mid"; // Insert your DELETE query here
    $stmt6 = $con->prepare($query6);
    $stmt6->bindParam(':mid', $mid); //Binding the ID for the query

    $query10 = "DELETE FROM acting WHERE mid = :mid"; // Insert your DELETE query here
    $stmt10 = $con->prepare($query10);
    $stmt10->bindParam(':mid', $mid); //Binding the ID for the query

    $query9 = "DELETE FROM direction WHERE mid = :mid"; // Insert your DELETE query here
    $stmt9 = $con->prepare($query9);
    $stmt9->bindParam(':mid', $mid); //Binding the ID for the query

    $query7 = "BEGIN"; // Insert your DELETE query here
    $stmt7 = $con->prepare($query7);
    $stmt10->execute();
    $stmt9->execute();
    $stmt6->execute();
    $stmt5->execute();
    $stmt4->execute();
    $stmt3->execute();
    $stmt2->execute();
    $query8 = "commit"; // Insert your DELETE query here
    $stmt8 = $con->prepare($query6);
    
    
    if($stmt1->execute()){
        header('Location: movies.php'); //Redirecting back to the main page
    }else{
        die('Could not remove'); //Something went wrong
    }
    
}

catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>