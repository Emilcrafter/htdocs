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
  <a class="navbar-brand" href="users.php">Users</a>
  <li class="nav-item">
      <a class="nav-link" href="watchlist.php">Watchlist</a> <!--Insert your own php-file here -->
    </li>
  </ul>
</nav>
</div>
<!--Styling HTML ends and the real work begins below-->

<?php

include 'connection.php'; //Init a connection


$query_showall = "SELECT customer.cid, customer.fname, customer.lname, c_info.email, customer.password FROM customer NATURAL JOIN c_info ORDER BY cid";
    $stmt = $con->prepare( $query_showall );
    $stmt->execute(); //Execute query
    $num = $stmt->rowCount(); 
    echo "<table class='table table-responsive table-fix table-bordered'><thead class='thead-light'>";
    echo "<tr>";
        echo "<th>Cid</th>"; // Rename, add or remove columns as you like.
        echo "<th>First name</th>";
        echo "<th>Last name</th>";
        echo "<th>Email</th>";
        echo "<th>Password</th>";
        echo "</tr>";

    while ($rad = $stmt->fetch(PDO::FETCH_ASSOC)){ //Fetches data
        extract($rad);
        echo "<tr>";
        
        // Here is the data added to the table
        echo "<td>{$cid}</td>"; //Rename, add or remove columns as you like
        echo "<td>{$fname}</td>";
        echo "<td>{$lname}</td>";
        echo "<td>{$email}</td>";
        echo "<td>{$password}</td>";
        echo "</tr>"; 
    }
        echo "<tr>";
                echo "<td><a href='users.php' class='btn btn-danger'>Go back to log in</a></td>";
        echo "</tr>";
        echo "</table>"; 


?>
 
</body>
</html>

</body>
</html>