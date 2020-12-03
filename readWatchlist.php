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

    $query = "SELECT media.mid, media.name, watchlist.twatched, rating.rate FROM media NATURAL JOIN watchlist LEFT JOIN rating ON watchlist.mid = rating.mid WHERE watchlist.pid = :pid";
    $stmt = $con->prepare($query);

    $stmt->bindParam(':pid', $pid);

    $stmt->execute();
    $num = $stmt->rowCount(); //Aquire number of rows

?>


 
<!-- The HTML-Form. Rename, add or remove columns for your insert here -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?pid={$pid}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
    <?php 

        echo "<tr>";
            echo "<th>Movie name</th>"; // Rename, add or remove columns as you like.
        echo "<th>Procentage watched</th>";
        echo "<th>Rating</th>";
        echo "<th>Make new rating</th>";
        echo "</tr>";
    while ($rad = $stmt->fetch(PDO::FETCH_ASSOC)){ //Fetches data
        extract($rad);
        echo "<tr>";
        
        // Here is the data added to the table
            echo "<td>{$name}</td>"; //Rename, add or remove columns as you like
        echo "<td>{$twatched}</td>";
        echo "<td>{$rate}</td>";
        echo "<td><a href='ratemovie.php?pid={$pid}&mid={$mid}' class='btn btn-info m-r-1em'>Rate this movie</a><td>";
        echo "</tr>"; 
    }
        echo "<tr>";
                echo "<td><a href='users.php' class='btn btn-danger'>Go back to log in</a></td>";
        echo "</tr>";
    ?>

        </tr>
    </table>
</form>
</body>
</html>

</body>
</html>