<!--Here is some styling HTML you don't need to pay attention to-->
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
<style>
.container {margin: auto; align-content: center;}
.table-fix {box-shadow: 0px 0px 5px 1px; display: table; }
</style>
</head>
<body>
<div class="container">
<div class="page-header">
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">

  <ul class="navbar-nav">
	<li class="nav-item">
		<a class="nav-link" href="movies.php">Movies</a>
	</li>
    <li class="nav-item">
		<a class="nav-link" href="createmovies.php">Add movie</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="users.php">Users</a> <!--Insert your own php-file here -->
    </li>
  <a class="navbar-brand" href="watchlist.php">Watchlist</a>
  </ul>
</nav>
</div>

<!--Styling HTML ends and the real work begins below-->

<?php
 
 include 'connection.php'; //Init a connection

$pid=isset($_GET['pid']) ? $_GET['pid'] : die('ERROR: Record ID not found.'); //The parameter value from the click is aquired
$mid=isset($_GET['mid']) ? $_GET['mid'] : die('ERROR: Record ID not found.'); //The parameter value from the click is aquired


 if($_POST){ //Has the form been submitted?
      
    $newrate=htmlspecialchars(strip_tags($_POST['newrate'])); //Rename, add or remove columns as you like

    
     try{


        $query1 = "UPDATE rating
        SET rate = :newrate 
        WHERE  mid=$mid AND pid = $pid";

         $stmt1 = $con->prepare($query1);
         $stmt1 ->bindParam(':newrate', $newrate);


         // Execute the query
         $stmt1->execute();
             echo "<div class='alert alert-success'>Record was updated.</div>";
            
     }
     catch(PDOException $exception){ //In case of error
         die('ERROR: ' . $exception->getMessage());
     }
 }

 ?>


 
<!-- The HTML-Form. Rename, add or remove columns for your insert here -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?pid={$pid}" . "&mid={$mid}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
    <?php 


        echo "<tr>";
        echo "<td>Rate the movie 1-10:</td>";
        echo "<td><input type='number' name='newrate' class='form-control' /></td>";
        echo "</tr>"; 
    
        echo "<tr>";
                echo "<td><a href='users.php' class='btn btn-danger'>Go back to log in</a></td>";
                echo "<td><input type='submit' value='Save Changes' class='btn btn-primary' /><td>";
        echo "</tr>";
    ?>

        </tr>
    </table>
</form>
</body>
</html>

</body>
</html>