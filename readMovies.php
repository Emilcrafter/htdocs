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
            <h1>Movie information</h1>
        </div>
<!--Styling HTML ends and the real work begins below-->

         
<?php

$name=isset($_GET['name']) ? $_GET['name'] : die('ERROR: Record ID not found.'); //The parameter value from the click is aquired
 
include 'connection.php';
 
try {
    $query = "SELECT media.name, media.mid, media.year, media.length, media.age_restriction, media.release_date, director.dname FROM director NATURAL JOIN direction NATURAL JOIN media WHERE mid = :name"; // Put query fetching data from table here
    $stmt = $con->prepare( $query );
    $stmt->bindParam(':name', $name); //Bind the ID for the query
    $stmt->execute(); //Execute query
    $num = $stmt->rowCount();

    $name1 = null;
    $mid1 = null;
    $year1 = null;
    $length1 = null;
    $age_restriction1 = null;
    $release_date1 = null;
    $dname1 = null;
    $aname1 = null;

    $dnametemp = null;
    $anametemp = null;

    if($num>0){ //Is there any data/rows?

        while ($rad = $stmt->fetch(PDO::FETCH_ASSOC)){ //Fetches data
            extract($rad);
            $name1 = $name;
            $mid1 = $mid;
            $year1 = $year;
            $length1 = $length;
            $age_restriction1 = $age_restriction;
            $release_date1 = $release_date;
            
            if ($dnametemp != $dname){
                $dname1 = $dname1 . $dname . "<br>" ."<br>";
            }
            $dnametemp = $dname;
        }
    }
    
    $actor_query = "SELECT aname from actor NATURAL JOIN acting where mid =:mid"; // Put query fetching data from table here
    $stmt = $con->prepare( $actor_query );
    $stmt->bindParam(':mid', $mid); //Bind the ID for the query
    $stmt->execute(); //Execute query
    $num = $stmt->rowCount(); 

    if($num>0){ //Is there any data/rows?

        while ($rad = $stmt->fetch(PDO::FETCH_ASSOC)){ //Fetches data
            extract($rad);
            if ($anametemp != $aname){
                $aname1 = $aname1 . $aname . "<br>" ."<br>";
            }
            $anametemp = $aname;
        }
    }

    echo "<table class='table table-responsive table-fix table-bordered'><thead class='thead-light'>";
    echo "<tr>";
    echo "<th>Name</th>";
    echo "<th>mID</th>";
    echo "<th>Year</th>";
    echo "<th>Lenght</th>";
    echo "<th>Age restriction</th>";
    echo "<th>Release date</th>";
    echo "<th>Directors</th>";
    echo "<th>Actors</th>";
    echo "</tr>";

    echo "<tr>";
    
    // Here is the data added to the table
    echo "<td>{$name1}</td>";
    echo "<td>{$mid1}</td>";
    echo "<td>{$year1}</td>";
    echo "<td>{$length1}</td>";
    echo "<td>{$age_restriction1}</td>";
    echo "<td>{$release_date1}</td>";
    echo "<td>{$dname1}</td>";
    echo "<td>{$aname1}</td>";
    
    echo "</td>";
    echo "</tr>";

    echo "</table>";    
        /*
        $name = $row['name']; //Store data. Rename, add or remove columns as you like.
        $mID = $row['mid'];
        $relyear = $row['year'];
        $length = $row['length'];
        $age_restriction = $row['age_restriction'];
        $releasedate = $row['release_date'];
        $dname = $row['dname'];
        $aname = $row['aname'];
        */
    
    
    
}
 

catch(PDOException $exception){ //In case of error
    die('ERROR: ' . $exception->getMessage());
}
?>
 <!-- Here is how we display our data. Rename, add or remove columns as you like-->
<table class='table table-hover table-responsive table-bordered'>
    <!--
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
        <td>dname</td>
        <td><?php echo htmlspecialchars($dname, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>aname</td>
        <td><?php echo htmlspecialchars($aname, ENT_QUOTES);  ?></td>
    </tr>
	-->
	
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