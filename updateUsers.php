<!--Here is some styling HTML you don't need to pay attention to-->
<!DOCTYPE HTML>
<html>
<head>
    <title>Update users</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />  
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Update movieinfo</h1>
        </div>
     
<!--Styling HTML ends and the real work begins below-->	 
<?php
		
$pid=isset($_GET['pid']) ? $_GET['pid'] : die('ERROR: Record ID not found.'); //The parameter value from the click is aquired
$cid = strrev(substr(strrev($pid), 1));
include 'connection.php'; //Init the connection
 
try { //Aquire the already existing data

     //Binding ID for the query
     
 //Fetching the data
     //Rename, add or remove columns as you like


     $query = "SELECT customer.fname, customer.lname, c_info.dob, c_info.phone, c_info.email, c_info.address, customer.disc, subscription.stype, subscription.sdate, subscription.edate, subscription.payment FROM c_info NATURAL JOIN customer NATURAL JOIN subscription WHERE cid = :cid"; // Put query fetching data from table here
     $stmt = $con->prepare( $query );
  
     $stmt->bindParam(':cid', $cid); //Bind the ID for the query
 
     $stmt->execute(); //Execute query
  
     $row = $stmt->fetch(PDO::FETCH_ASSOC); //Fetchs data
  
     $fname = $row['fname']; //Store data. Rename, add or remove columns as you like.
     $lname = $row['lname'];
     $dob = $row['dob'];
     $phone = $row['phone'];
     $email = $row['email'];
     $address = $row['address'];
     $stype = $row['stype'];
     $disc = $row['disc'];
     $sdate = $row['sdate'];
     $edate = $row['edate'];
     $payment = $row['payment'];
     print_r($payment);
}
 
catch(PDOException $exception){ //In case of error
    die('ERROR: ' . $exception->getMessage());
}
?>
 
<?php
 
 if($_POST){ //Has the form been submitted?
      
    $fname=htmlspecialchars(strip_tags($_POST['fname'])); //Rename, add or remove columns as you like
    $lname=htmlspecialchars(strip_tags($_POST['lname']));
    $dob=htmlspecialchars(strip_tags($_POST['dob']));
    $phone = htmlspecialchars(strip_tags($_POST['phone']));
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $address = htmlspecialchars(strip_tags($_POST['address']));
    $disc = htmlspecialchars(strip_tags($_POST['disc']));
    $stype = htmlspecialchars(strip_tags($_POST['stype']));
    $sdate = htmlspecialchars(strip_tags($_POST['sdate']));
    $edate = htmlspecialchars(strip_tags($_POST['edate']));
    $payment = htmlspecialchars(strip_tags($_POST['payment']));

     try{
        if(empty($lname) && empty($disc)){
            $query1 = "UPDATE customer 
            SET fname=:fname 
            WHERE cid = $cid";
        }
        elseif(empty($lname)){
            $query1 = "UPDATE customer 
            SET fname=:fname, disc=:disc 
            WHERE cid = $cid";
        }
        elseif(empty($disc)){
            $query1 = "UPDATE customer 
            SET fname=:fname, lname=:lname
            WHERE cid = $cid";
        }
        else{
            $query1 = "UPDATE customer 
            SET fname=:fname, lname=:lname, disc=:disc 
            WHERE cid = $cid";
        }
        $query2 = "UPDATE c_info
        SET phone=:phone, dob=:dob, email=:email, address=:address
        WHERE cid = $cid";

        $query3 = "UPDATE subscription
        SET stype=:stype, sdate=:sdate, edate=:edate, payment=:payment
        WHERE cid = $cid";

         $stmt1 = $con->prepare($query1);
         $stmt1 ->bindParam(':fname', $fname);
         $stmt1 ->bindParam(':lname', $lname);
         $stmt1 ->bindParam(':disc', $disc);


         $stmt2 = $con->prepare($query2);
         $stmt2 ->bindParam(':phone', $phone);
         $stmt2 ->bindParam(':email', $email);
         $stmt2 ->bindParam(':address', $address);
         $stmt2 ->bindParam(':dob', $dob);

         $stmt3 = $con->prepare($query3);
         $stmt3 ->bindParam(':stype', $stype);
         $stmt3 ->bindParam(':sdate', $sdate);
         $stmt3 ->bindParam(':edate', $edate);
         $stmt3 ->bindParam(':payment', $payment);

         // Execute the query
         if($stmt1->execute() && $stmt2->execute() && $stmt3->execute()){//Executes and check if correctly executed
             echo "<div class='alert alert-success'>Record was updated.</div>";
         }else{
            print_r($stmt1->errorInfo()."1");
            print_r($stmt2->errorInfo()."2");
            print_r($stmt2->errorInfo()."3");
             echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
         }
          
     }
      
     catch(PDOException $exception){ //In case of error
         die('ERROR: ' . $exception->getMessage());
     }
 }
 ?>
 
<!-- The HTML-Form. Rename, add or remove columns for your update here -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?pid={$pid}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>First name</td>
            <td><input type='text' name='fname' value="<?php echo htmlspecialchars($fname, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Last name</td>
            <td><input type='text' name='lname' value="<?php echo htmlspecialchars($lname, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Date of birth</td>
            <td><input type='date' name='dob' value="<?php echo htmlspecialchars($dob, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Phone number</td>
            <td><input type='text' name='phone' value="<?php echo htmlspecialchars($phone, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
		
		<tr>
            <td>E-mail address</td>
            <td><input type='text' name='email' value="<?php echo htmlspecialchars($email, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
		
		<tr>
            <td>Address of residence</td>
            <td><input type='text' name='address' value="<?php echo htmlspecialchars($address, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        
        <tr>
            <td>Discount</td>
            <td><input type='number' name='disc' value="<?php echo htmlspecialchars($disc, ENT_QUOTES);?>" min=0 max=25 class='form-control' /></td>
        </tr>

        <tr>
            <td>Subscription type</td>
            <td><input type='text' name='stype' value="<?php echo htmlspecialchars($stype, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>

        <tr>
            <td>Starting date</td>
            <td><input type='date' name='sdate' value="<?php echo htmlspecialchars($sdate, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>

        <tr>
            <td>Ending date</td>
            <td><input type='date' name='edate' value="<?php echo htmlspecialchars($edate, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Payment sum</td>
            <td><input type='text' name='payment' value="<?php echo htmlspecialchars($payment, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <?php
            echo "<td></td>";
            echo "<td>";
                echo "<input type='submit' value='Save Changes' class='btn btn-primary' />";
                echo "<a href='readUsers.php?pid={$pid}' class='btn btn-danger'>Back to user</a>";
            echo "</td>";
            ?>
        </tr>
    </table>
</form>
    </div>
</body>
</html>