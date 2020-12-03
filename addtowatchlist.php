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

    $mid = isset($_GET['mid']) ? $_GET['mid'] : ''; 

    if ($_POST) {

        try {

            // Put query inserting data to table here

            $pid = htmlspecialchars(strip_tags($_POST['pid']));
            $twatched = htmlspecialchars(strip_tags($_POST['twatched']));

            $query = "INSERT INTO watchlist(pID, mid, twatched) VALUES(:pid, :mid, :twatched)";

            $stmt = $con->prepare($query); // prepare query for execution
            $stmt->bindParam(':mid', $mid);
            $stmt->bindParam(':pid', $pid);
            $stmt->bindParam(':twatched', $twatched);

            if ($stmt->execute()) { //Executes and check if correctly executed
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
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?mid={$mid}"); ?>" method="post">
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>Profile id</td>
                <td><input type='number' name='pid' class='form-control' /></td>
            </tr>
            <tr>
                <td>Time watched</td>
                <td><input type='number' name='twatched' class='form-control' min = 0 max = 100/></td>
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