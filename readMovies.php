<!--Here is some styling HTML you don't need to pay attention to-->
<!DOCTYPE HTML>
<html>
<head>
    <title>LMS movies</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>movie information</h1>
        </div>
<!--Styling HTML ends and the real work begins below-->

         
<?php

$name=isset($_GET['name']) ? $_GET['name'] : die('ERROR: Record ID not found.'); //The parameter value from the click is aquired
 
include 'connection.php';
 
try {
    $query = "SELECT * FROM media WHERE mID = :name"; // Put query fetching data from table here
    $stmt = $con->prepare( $query );
 
    $stmt->bindParam(':name', $name); //Bind the ID for the query

    $stmt->execute(); //Execute query
 
    $row = $stmt->fetch(PDO::FETCH_ASSOC); //Fetchs data
 
    $name = $row['name']; //Store data. Rename, add or remove columns as you like.
    $mID = $row['mid'];
	$relyear = $row['year'];
	$length = $row['length'];
	$age_restriction = $row['age_restriction'];
	$releasedate = $row['release_date'];
}
 

catch(PDOException $exception){ //In case of error
    die('ERROR: ' . $exception->getMessage());
}
?>
 <!-- Here is how we display our data. Rename, add or remove columns as you like-->
<table class='table table-hover table-responsive table-bordered'>
    <tr>
        <td>Name</td>
        <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
    </tr>
	
	<tr>
        <td>mID</td>
        <td><?php echo htmlspecialchars($mID, ENT_QUOTES);  ?></td>
    </tr>
	
	<tr>
        <td>Release_year</td>
        <td><?php echo htmlspecialchars($relyear, ENT_QUOTES);  ?></td>
    </tr>
	
	<tr>
        <td>length</td>
        <td><?php echo htmlspecialchars($length, ENT_QUOTES);  ?></td>
    </tr>
	
	<tr>
        <td>age_restriction</td>
        <td><?php echo htmlspecialchars($age_restriction, ENT_QUOTES);  ?></td>
    </tr>
	
    <tr>
        <td>release_date</td>
        <td><?php echo htmlspecialchars($releasedate, ENT_QUOTES);  ?></td>
    </tr>
	

	
	
	
	
    <tr>
        <td></td>
        <td>
            <a href='movies.php' class='btn btn-danger'>Back to read products</a>
        </td>
    </tr>
</table> 
    </div> 
</body>
</html>