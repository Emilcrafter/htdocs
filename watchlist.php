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

    echo "<h1> You need to log in and choose a profile to see your watchlist. </h1>";
    
    echo "<tr>";
        echo "<td><a href='Users.php'class='btn btn-info m-r-1em'>LOG IN HERE</a>"; 
        echo "</td>";
    echo "</tr>";


?>

</body>
</html>

</body>
</html>