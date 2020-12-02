<!--Here is some styling HTML you don't need to pay attention to-->
<!DOCTYPE HTML>
<html>
<head>
    <title>Update movies</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />  
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Update movieinfo</h1>
        </div>
     
<!--Styling HTML ends and the real work begins below-->	 
<?php
		
$mid=isset($_GET['name']) ? $_GET['name'] : die('ERROR: Record ID not found.'); //The parameter value from the click is aquired
 
include 'connection.php'; //Init the connection
 
try { //Aquire the already existing data

     //Binding ID for the query
     
 //Fetching the data
     //Rename, add or remove columns as you like


    $query = "SELECT * FROM media WHERE mID = $mid"; //Put query gathering the data here
    $stmt = $con->prepare( $query );
    $stmt->execute();
     
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $title = $row['name'];
	$year = $row['year'];
	$length = $row['length'];
	$age_restriction = $row['age_restriction'];
    $release_date = $row['release_date'];
}
 
catch(PDOException $exception){ //In case of error
    die('ERROR: ' . $exception->getMessage());
}
?>
 
<?php
 
 if($_POST){ //Has the form been submitted?
      
    $title=htmlspecialchars(strip_tags($_POST['title'])); //Rename, add or remove columns as you like
    $year=htmlspecialchars(strip_tags($_POST['year']));
    $length=htmlspecialchars(strip_tags($_POST['length']));
    $age_restriction = htmlspecialchars(strip_tags($_POST['age_restriction']));
    $release_date = htmlspecialchars(strip_tags($_POST['release_date']));
     try{
        if(empty($age_restriction) && empty($release_date)){
            $query = "UPDATE media 
            SET name=:title, length=:length, year=:year 
            WHERE mid = $mid";
        }
        elseif(empty($age_restriction)){
            $query = "UPDATE media 
            SET name=:title, length=:length, year=:year, release_date=:release_date 
            WHERE mid = $mid";
        }
        elseif(empty($releasedate)){
            $query = "UPDATE media 
            SET name=:title, length=:length, year=:year, age_restriction=:age_restriction
            WHERE mid = $mid";
        }
        else{
            $query = "UPDATE media 
            SET name=:title, length=:length, year=:year, age_restriction=:age_restriction, release_date=:release_date 
            WHERE mid = $mid";
        }

         $stmt = $con->prepare($query);
         $stmt ->bindParam(':title', $title);
         $stmt ->bindParam(':age_restriction', $age_restriction);
         $stmt ->bindParam(':release_date', $release_date);
         $stmt ->bindParam(':year', $year);
         $stmt ->bindParam(':length', $length);



         // Execute the query
         if($stmt->execute()){//Executes and check if correctly executed
             echo "<div class='alert alert-success'>Record was updated.</div>";
         }else{
            print_r($stmt->errorInfo());
             echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
         }
          
     }
      
     catch(PDOException $exception){ //In case of error
         die('ERROR: ' . $exception->getMessage());
     }
 }
 ?>
 
<!-- The HTML-Form. Rename, add or remove columns for your update here -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?name={$mid}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Title</td>
            <td><input type='text' name='title' value="<?php echo htmlspecialchars($title, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Release Year</td>
            <td><input type='text' name='year' value="<?php echo htmlspecialchars($year, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Length</td>
            <td><input type='number' name='length' value="<?php echo htmlspecialchars($length, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
		
		<tr>
            <td>Age restriction</td>
            <td><input type='text' name='age_restriction' value="<?php echo htmlspecialchars($age_restriction, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
		
		<tr>
            <td>Release date</td>
            <td><input type='text' name='release_date' value="<?php echo htmlspecialchars($release_date, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
		
        <tr>
            <td></td>
            <td>
                <input type='submit' value='Save Changes' class='btn btn-primary' />
                <a href='movies.php' class='btn btn-danger'>Back to read products</a>
            </td>
        </tr>
    </table>
</form>
    </div>
</body>
</html>