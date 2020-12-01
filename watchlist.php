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


<?php

include 'connection.php'; //Init a connection

if($_POST){
    $query = "SELECT media.name, watchlist.twatched FROM watchlist NATURAL JOIN media WHERE pid = :pid";
    $stmt = $con->prepare($query);

    $pid=htmlspecialchars(strip_tags($_POST['pid'])); //Rename, add or remove columns as you like
    $stmt->bindParam(':pid', $pid);

    $stmt->execute();
    $num = $stmt->rowCount(); //Aquire number of rows

    if($num>0){ //Is there any data/rows?
        echo "<table class='table table-responsive table-fix table-bordered'><thead class='thead-light'>";
        echo "<tr>";
            echo "<th>Movie name</th>"; // Rename, add or remove columns as you like.
        echo "<th>Minutes Watched</th>";
        echo "</tr>";
    while ($rad = $stmt->fetch(PDO::FETCH_ASSOC)){ //Fetches data
        extract($rad);
        echo "<tr>";
        
        // Here is the data added to the table
            echo "<td>{$name}</td>"; //Rename, add or remove columns as you like
        echo "<td>{$twatched}</td>";
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
            <td>pid</td>
            <td><input type='number' name='pid' class='form-control' /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type='submit' value='Save' class='btn btn-primary' />
                <a href='movies.php' class='btn btn-danger'>Go back</a>
            </td>
        </tr>
    </table>
</form>
</body>
</html>

</body>
</html>