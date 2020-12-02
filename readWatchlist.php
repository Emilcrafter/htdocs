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

$_POST['pid'] = $pid;

if($_POST){
    $query = "SELECT media.name, watchlist.twatched, rating.rate FROM watchlist NATURAL JOIN media NATURAL JOIN rating WHERE pid = :pid";
    $stmt = $con->prepare($query);

    $pid = $_POST['pid'];
    $stmt->bindParam(':pid', $pid);

    $stmt->execute();
    $num = $stmt->rowCount(); //Aquire number of rows

    if($num>0){ //Is there any data/rows?
        echo "<table class='table table-responsive table-fix table-bordered'><thead class='thead-light'>";
        echo "<tr>";
            echo "<th>Movie name</th>"; // Rename, add or remove columns as you like.
        echo "<th>Minutes Watched</th>";
        echo "<th>Rating</th>";
        echo "</tr>";
    while ($rad = $stmt->fetch(PDO::FETCH_ASSOC)){ //Fetches data
        extract($rad);
        echo "<tr>";
        
        // Here is the data added to the table
            echo "<td>{$name}</td>"; //Rename, add or remove columns as you like
        echo "<td>{$twatched}</td>";
        echo "<td>{$rate}</td>";
        echo "</tr>";
    }
    echo "</table>";    
    }
    else{
      echo "<h1> Search gave no result </h1>";
    }

}
?>
 
<!-- The HTML-Form. Rename, add or remove columns for your insert here -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>
                <a href='users.php' class='btn btn-danger'>Go back to log in</a>
            </td>
        </tr>
    </table>
</form>
</body>
</html>

</body>
</html>