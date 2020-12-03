<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
</head>

<body>

    <!--Styling HTML ends and the real work begins below-->
    <?php

    include 'connection.php'; //Init a connection
    //bruh

    $cid = isset($_GET['cid']) ? $_GET['cid'] : ''; 
    $query0 = "SELECT pid FROM owns_profile WHERE cid = :cid"; // Insert your DELETE query here
    $stmt0 = $con->prepare($query0);
    $stmt0->bindParam(':cid', $cid); //Binding the ID for the query
    $stmt0->execute();
    $occupied = [];
    while ($row = $stmt0->fetch(PDO::FETCH_ASSOC)) {
        array_push($occupied, $row['pid']);
    }
    $profilenr = -1;
    foreach ([1, 2, 3] as &$num) {
        if (!in_array($cid.$num, $occupied)) {
            $profilenr = $num;
            break;
        }
    }
    $pid = $cid . $profilenr;
    
    if ($_POST) {

        try {

            // Put query inserting data to table here

            $pname = htmlspecialchars(strip_tags($_POST['pname']));
            $age_restriction = htmlspecialchars(strip_tags($_POST['age_restriction']));
            if(!empty($age_restriction)){
            $query = "INSERT INTO profile(pID, pname, profilenr, age_restriction) VALUES(:pid, :pname, :profilenr, :age_restriction)";
           
}
            else{
                $query = "INSERT INTO profile(pID, pname, profilenr) VALUES(:pid, :pname, :profilenr)";
            }
            $stmt = $con->prepare($query); // prepare query for execution
            $stmt->bindParam(':pname', $pname);
            $stmt->bindParam(':age_restriction', $age_restriction);
            $stmt->bindParam(':profilenr', $profilenr);
            $stmt->bindParam(':pid', $pid);
            $query2 = "INSERT INTO owns_profile(pID, cID) VALUES(:pid, :cid)";
            $stmt2 = $con->prepare($query2);
            $stmt2->bindParam(':pid', $pid);
            $stmt2->bindParam(':cid', $cid);

            if ($stmt->execute() && $stmt2->execute()) { //Executes and check if correctly executed
                echo "<div class='alert alert-success'>Record was saved.</div>";
            } else {
                echo "<div class='alert alert-danger'>Unable to save record.</div>";
                print_r($stmt->errorInfo());
            }
        } catch (PDOException $exception) { //In case of error
            die('ERROR: ' . $exception->getMessage());
        }
    }
    ?>

    <!-- The HTML-Form. Rename, add or remove columns for your insert here -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?cid={$cid}"); ?>" method="post">
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>Profile name</td>
                <td><input type='text' name='pname' class='form-control' /></td>
            </tr>
            <tr>
                <td>Age restriction</td>
                <td><select name="age_restriction" id="age_restriction" selected=''>
                        <option value=''>None</option>
                        <option value='Youth'>Youth</option>
                        <option value='Child<'>Child</option>
                    </select>
                <td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type='submit' value='Save' class='btn btn-primary' />
                    <a href='users.php' class='btn btn-danger'>Go back</a>
                </td>
            </tr>
        </table>
    </form>
</body>

</html>