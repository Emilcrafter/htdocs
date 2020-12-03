<!--Here is some styling HTML you don't need to pay attention to-->
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

if($_POST){

    try{
        
          // Put query inserting data to table here

        
 
        $mid=htmlspecialchars(strip_tags($_POST['mID']));
        $name=htmlspecialchars(strip_tags($_POST['name'])); //Rename, add or remove columns as you like
        $relyear=htmlspecialchars(strip_tags($_POST['relyear']));
        $length=htmlspecialchars(strip_tags($_POST['length']));
		$age_restriction=htmlspecialchars(strip_tags($_POST['age_restriction']));
        $releasedate=htmlspecialchars(strip_tags($_POST['release_date']));
        
        if(empty($age_restriction) && empty($release_date)){
            $query = "INSERT INTO media(mID,name,year,length) VALUES ($mid,$name,$relyear,$length)";
        }
        elseif(empty($age_restriction)){
            $query = "INSERT INTO media(mID,name,year,length,releasedate) VALUES ($mid,$name,$relyear,$length,$releasedate)";
        }
        elseif(empty($releasedate)){
            $query = "INSERT INTO media(mID,name,year,length,age_restriction) VALUES ($mid,$name,$relyear,$length,$age_restriction)";
        }
        else{
            $query = "INSERT INTO media(mID,name,year,length,age_restriction, releasedate) VALUES ($mid,$name,$relyear,$length,$age_restriction,$releasedate)";
        }
        $stmt = $con->prepare($query); // prepare query for execution


        if($stmt->execute()){ //Executes and check if correctly executed
            echo "<div class='alert alert-success'>Record was saved.</div>";
        }else{
            echo "<div class='alert alert-danger'>Unable to save record.</div>";
            print_r($stmt->errorInfo());
        }
    }
    catch(PDOException $exception){ //In case of error
        die('ERROR: ' . $exception->getMessage());
    }
}
?>
 
<!-- The HTML-Form. Rename, add or remove columns for your insert here -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>mID</td>
            <td><input type='number' name='mID' class='form-control' /></td>
        </tr>
        <tr>
            <td>Title</td>
            <td><input type='text' name='name' class='form-control' /></td>
        </tr>
        <tr>
            <td>year</td>
            <td><input type='number' name='relyear' class='form-control'/></td>
        </tr>
        <tr>
            <td>length</td>
            <td><input type='number' name='length' class='form-control' /></td>
        </tr>
		<tr>
            <td>age_restriction</td>
            <td><input type='text' name='age_restriction' class='form-control' /></td>
        </tr>
        <tr>
            <td>release_date</td>
            <td><input type='text' name='release_date' class='form-control' /></td>
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