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
            <h1>Your information</h1>
        </div>
<!--Styling HTML ends and the real work begins below-->

         
<?php

$pid=isset($_GET['pid']) ? $_GET['pid'] : die('ERROR: Record ID not found.'); //The parameter value from the click is aquired
 
include 'connection.php';

$cid = substr_replace($pid ,"",-1);

try {
    $query = "SELECT customer.fname, customer.lname, c_info.dob, c_info.phone, c_info.email, c_info.address, customer.disc, subscription.stype, subscription.sdate, subscription.edate, subscription.payment, subscription.ccn FROM c_info NATURAL JOIN customer NATURAL JOIN subscription WHERE cid = :cid"; // Put query fetching data from table here
    $query2 = "SELECT pname, age_restriction FROM profile WHERE pid=:pid";


    $stmt = $con->prepare($query);
    $stmt->bindParam(':cid', $cid); //Bind the ID for the query
    $stmt->execute(); //Execute query    
    $row = $stmt->fetch(PDO::FETCH_ASSOC); //Fetchs data

    $fname = $row['fname']; //Store data. Rename, add or remove columns as you like.
    $lname = $row['lname'];
	$dob = $row['dob'];
	$phone = $row['phone'];
	$email = $row['email'];
    $address = $row['address'];
    $disc = $row['disc'];
    $sdate = $row['sdate'];
    $stype = $row['stype'];
    $edate = $row['edate'];
    $payment = $row['payment'];
    $ccn = $row['ccn'];

    $stmt2 = $con->prepare($query2);
    $stmt2->bindParam(':pid', $pid);
    $stmt2->execute();
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

    $pname = $row2['pname'];
    $age_restriction = $row2['age_restriction'];
}
 

catch(PDOException $exception){ //In case of error
    die('ERROR: ' . $exception->getMessage());
}
?>
 <!-- Here is how we display our data. Rename, add or remove columns as you like-->
<table class='table table-hover table-responsive table-bordered'>
    <tr>
        <td>First name</td>
        <td><?php echo htmlspecialchars($fname, ENT_QUOTES);  ?></td>
    </tr>
	
	<tr>
        <td>Last name</td>
        <td><?php echo htmlspecialchars($lname, ENT_QUOTES);  ?></td>
    </tr>
	
	<tr>
        <td>Date of birth</td>
        <td><?php echo htmlspecialchars($dob, ENT_QUOTES);  ?></td>
    </tr>
	<tr>
        <td>Phone</td>
        <td><?php echo htmlspecialchars($phone, ENT_QUOTES);  ?></td>
    </tr>
	
	<tr>
        <td>Email</td>
        <td><?php echo htmlspecialchars($email, ENT_QUOTES);  ?></td>
    </tr>
	
    <tr>
        <td>Address</td>
        <td><?php echo htmlspecialchars($address, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Discount</td>
        <td><?php echo htmlspecialchars($disc, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Subscription Type</td>
        <td><?php echo htmlspecialchars($stype, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Subscription Start</td>
        <td><?php echo htmlspecialchars($sdate, ENT_QUOTES);  ?></td>
    </tr>

    <tr>
        <td>Subscription End</td>
        <td><?php echo htmlspecialchars($edate, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Subscription Fee</td>
        <td><?php echo htmlspecialchars($payment, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Profile Name</td>
        <td><?php echo htmlspecialchars($pname, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Age restriction</td>
        <td><?php echo htmlspecialchars($age_restriction, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>CCN</td>
        <td><?php echo htmlspecialchars($ccn, ENT_QUOTES);  ?></td>
    </tr>
    <tr> 
        <?php
            echo "<tr>";
                echo "<td><a href='readWatchlist.php?pid={$pid}'class='btn btn-info m-r-1em'>Watchlist</a>";
                echo "</td>";
                echo "<td><a href='updateUsers.php?pid={$pid}'class='btn btn-info m-r-1em'>Edit user</a>";
                echo "</td>";
                echo "<td><a href='Users.php' class='btn btn-danger'>Go back to Login</a>"; 
                echo "</td>";
            echo "</tr>";
         ?>
    </tr>
</table> 
    </div> 
</body>
</html>