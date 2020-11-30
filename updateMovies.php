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
		
$name=isset($_GET['name']) ? $_GET['name'] : die('ERROR: Record ID not found.'); //The parameter value from the click is aquired
 
include 'connection.php'; //Init the connection
 
try { //Aquire the already existing data
    $query = "SELECT * FROM country WHERE name = :name"; //Put query gathering the data here
    $stmt = $con->prepare( $query );

    $stmt->bindParam(':name', $name); //Binding ID for the query
     
    $stmt->execute();
     
    $row = $stmt->fetch(PDO::FETCH_ASSOC); //Fetching the data
     
    $code = $row['code']; //Rename, add or remove columns as you like
	$capital = $row['capital'];
	$province = $row['province'];
	$area = $row['area'];
	$population = $row['population'];
}
 
catch(PDOException $exception){ //In case of error
    die('ERROR: ' . $exception->getMessage());
}
?>
 
<?php
 
 if($_POST){ //Has the form been submitted?
      
     try{
         $query = "UPDATE country 
                     SET code=:code, capital=:capital, province=:province, area=:area, population=:population 
                     WHERE name = :name"; //Put your query for updating data here
         $stmt = $con->prepare($query);
  

         $code=htmlspecialchars(strip_tags($_POST['code'])); //Rename, add or remove columns as you like
         $capital=htmlspecialchars(strip_tags($_POST['capital']));
         $province=htmlspecialchars(strip_tags($_POST['province']));
		 $area = htmlspecialchars(strip_tags($_POST['area']));
		 $population = htmlspecialchars(strip_tags($_POST['population']));
		 
        $stmt->bindParam(':name', $name); //Binding parameters for query
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':capital', $capital);
		$stmt->bindParam(':province', $province);
        $stmt->bindParam(':area', $area);
        $stmt->bindParam(':population', $population);
          
         // Execute the query
         if($stmt->execute()){//Executes and check if correctly executed
             echo "<div class='alert alert-success'>Record was updated.</div>";
         }else{
             echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
         }
          
     }
      
     catch(PDOException $exception){ //In case of error
         die('ERROR: ' . $exception->getMessage());
     }
 }
 ?>
 
<!-- The HTML-Form. Rename, add or remove columns for your update here -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?name={$name}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Code</td>
            <td><input type='text' name='code' value="<?php echo htmlspecialchars($code, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Capital</td>
            <td><input type='text' name='capital' value="<?php echo htmlspecialchars($capital, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Province</td>
            <td><input type='text' name='province' value="<?php echo htmlspecialchars($province, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
		
		<tr>
            <td>Area</td>
            <td><input type='text' name='area' value="<?php echo htmlspecialchars($area, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
		
		<tr>
            <td>Population</td>
            <td><input type='text' name='population' value="<?php echo htmlspecialchars($population, ENT_QUOTES);  ?>" class='form-control' /></td>
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