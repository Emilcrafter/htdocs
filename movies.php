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
  <a class="navbar-brand" href="movies.php">Movies</a>
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="createmovies.php">Add movie</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="users.php">Users</a> <!--Insert your own php-file here -->
    </li>
	<li class="nav-item">
      <a class="nav-link" href="watchlist.php">Watchlist</a> <!--Insert your own php-file here -->
    </li>
  </ul>
</nav>
</div>



<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Search</td>
            <td><input type='text' name='keyword' class='form-control' />
            <input type="submit">
            </td>
            <td>Name<input type='checkbox' name='namesearch' class='form-control' value = "LOWER(media.name)" checked/></td>
            <td>Actors<input type='checkbox' name='actorsearch' class='form-control' value = "LOWER(actor.aname)"/></td>
            <td>Year<input type='number' name='yearsearch' class='form-control' /></td>
            <td>Country<input type='checkbox' name='countrysearch' class='form-control' value = "LOWER(nationality.nname)"/></td>
            <td>Director<input type='checkbox' name='directorsearch' class='form-control' value = "LOWER(director.dname)"/></td>
            <td>Genres<input type='checkbox' name='genresearch' class='form-control' value = "LOWER(mgenre.gname)"/></td>
            <td>Length<input type='checkbox' name='lengthsearch' class='form-control' value = "Yes"/>
            From<input type ='number' name='length_from' class='form-control' min=0>To
            <input type ='number' name='length_to' class='form-control' min = 0></td>
            <td><select name="search_type" id="search_type" selected="ANY">
            <option value="ANY">Any</option>
            <option value="ALL">All</option>
            </select></td>
        </tr>
    </table>
</form>

<!--Styling HTML ends and the real work begins below-->

<?php


include 'connection.php'; //Init a connection

$query = "SELECT * FROM media NATURAL JOIN acting NATURAL JOIN actor NATURAL JOIN direction NATURAL JOIN director NATURAL JOIN nationality NATURAL JOIN mgenre WHERE LOWER(media.name) LIKE LOWER(:keyword)";

$nsearch = 0;
$sep = "OR";
$namesearch = isset($_POST['namesearch']) ? $_POST['namesearch'] : '';
$actorsearch = isset($_POST['actorsearch']) ? $_POST['actorsearch'] : '';
$yearsearch = isset($_POST['yearsearch']) ? $_POST['yearsearch'] : '';
$countrysearch = isset($_POST['countrysearch']) ? $_POST['countrysearch'] : '';
$genresearch = isset($_POST['genresearch']) ? $_POST['genresearch'] : '';
$lengthsearch = isset($_POST['lengthsearch']) ? $_POST['lengthsearch'] : '';
$length_from = isset($_POST['length_from']) ? $_POST['length_from'] : '';
$length_to = isset($_POST['length_to']) ? $_POST['length_to'] : '';
$search_type = isset($_POST['search_type']) ? $_POST['search_type'] : '';
print_r($search_type."aaa");
if($search_type == "ANY"){
  $sep = "OR";
}
else{
  $sep = "AND";
}
$qarr = array($namesearch, $actorsearch, $yearsearch, $countrysearch, $genresearch);
$qarr2 = [];
foreach(array_slice($qarr, 1) as &$value){
  if(!empty($value)){
    array_push($qarr2, $sep." LOWER(".$value.") LIKE LOWER(:keyword)");
  }
}
print_r($qarr2);

$stmt = $con->prepare($query);
$keyword= isset($_POST['keyword']) ? $_POST['keyword'] : ''; //Is there any data sent from the form?

$keyword = "%".$keyword."%";
$stmt->bindParam(':keyword', $keyword);

$stmt->execute();

$num = $stmt->rowCount(); //Aquire number of rows

if($num>0){ //Is there any data/rows?
    echo "<table class='table table-responsive table-fix table-bordered'><thead class='thead-light'>";
    echo "<tr>";
        echo "<th>namn</th>"; // Rename, add or remove columns as you like.
    echo "<th>mID</th>";
    echo "<th>buttons</th>";
    echo "</tr>";
while ($rad = $stmt->fetch(PDO::FETCH_ASSOC)){ //Fetches data
    extract($rad);
    echo "<tr>";
    //print_r(get_defined_vars());
		// Here is the data added to the table
        echo "<td>{$name}</td>"; //Rename, add or remove columns as you like
        echo "<td>{$mid}</td>";
		//Here are the buttons for update, delete and read.
		    echo "<td><a href='readMovies.php?name={$mid}'class='btn btn-info m-r-1em'>Read</a>"; // Replace with ID-variable, to make the buttons work
		    echo "<a href='updateMovies.php?name={$mid}' class='btn btn-primary m-r-1em'>Update</a>";// Replace with ID-variable, to make the buttons work
		    echo "<a href='deleteMovies.php?name={$mid}' class='btn btn-danger'>Delete</a></td>";// Replace with ID-variable, to make the buttons work
		echo "</td>";
    echo "</tr>";
}
echo "</table>";    
}
else{
	echo "<h1> Search gave no result </h1>";
}
?>
</div>
</body>
</html>