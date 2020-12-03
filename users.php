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
if(isset($_GET['error'])){
    $error = $_GET['error'];
    if($error == 'userDelete'){
        echo "<div class='alert alert-danger'>You may not delete all profiles from a user account. Please log in again.</div>";
    }

}


if($_POST){
    $query = "SELECT customer.cid, c_info.email, customer.password FROM c_info INNER JOIN customer ON c_info.cid = customer.cid WHERE c_info.email = :email_input";
    $stmt = $con->prepare($query);

    $email_input=htmlspecialchars(strip_tags($_POST['email_input'])); //Rename, add or remove columns as you like
    $stmt->bindParam(':email_input', $email_input);
    $password_input=htmlspecialchars(strip_tags($_POST['password_input'])); //Rename, add or remove columns as you like


    if($stmt->execute()){ //Executes and check if correctly executed
    }else{
        echo "<div class='alert alert-danger'>Your email or password is incorrect.</div>";
        print_r($stmt->errorInfo());
    }
    $numberOfProfiles = 0;
    $num = $stmt->rowCount();
    if($num>0){
        $rad = $stmt->fetch(PDO::FETCH_ASSOC); //Fetches data
            extract($rad);
            $pid1 = $cid . "1";
            $pid2 = $cid . "2";
            $pid3 = $cid . "3";

            $profile_query = "SELECT pid, pname FROM profile WHERE pid=$pid1 OR pid=$pid2 OR pid=$pid3";
            $stmt = $con->prepare($profile_query);
            $stmt->execute();
            $num = $stmt->rowCount();
            $correct_password = str_replace(' ', '', $password);


            if($num>0 && $correct_password == $password_input){ //Is there any data/rows?
                echo "<table class='table table-responsive table-fix table-bordered'><thead class='thead-light'>";
                echo "<tr>";
                echo "<th>Profile Name</th>";
                echo "<th>Choose Profile</th>";
                echo "<th>Delete Profile</th>";
                echo "</tr>";
            while ($rad = $stmt->fetch(PDO::FETCH_ASSOC)){ //Fetches data
                extract($rad);
                echo "<tr>";
                
                // Here is the data added to the table
                echo "<td>{$pname}</td>";
                echo "<td><a href='readUsers.php?pid={$pid}'class='btn btn-info m-r-1em'>LOG IN</a>"; 
                echo "</td>";
                echo "<td><a href='deleteUsers.php?pid={$pid}&n={$num}'class='btn btn-danger m-r-1em'>DELETE PROFILE</a>"; 
                echo "</td>";
                echo "</tr>";
            }
            if($num<3){
                echo "<td><a href='createProfile.php?cid={$cid}'class='btn btn-info m-r-1em'>CREATE PROFILE</a>"; 
            }
            echo "</table>";    
            }

            else{
            echo "<h1> Your email or password is incorrect, please try again. </h1>";
            }
    }
    else{
        echo "<h1> Your email or password is incorrect, please try again. </h1>";
    }

}

?>
 
<!-- The HTML-Form. Rename, add or remove columns for your insert here -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Email</td>
            <td><input type='text' name='email_input' class='form-control' /></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type='text' name='password_input' class='form-control' /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type='submit' value='Log in' class='btn btn-primary' />
                <a href='Users.php' class='btn btn-danger'>Go back</a>
            </td>
            <td>
            <a href='showallUsers.php' class='btn btn-primary'>Show all Users</a>
            </td>
        </tr>
    </table>
</form>
</body>
</html>

</body>
</html>