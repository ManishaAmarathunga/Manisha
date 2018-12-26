
 

  
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
    
</head>
<body>

    <?php

require("db.php");
 $conn=mysqli_connect ("localhost", 'root', '','locations');
    if (!$conn) {
       die('Not connected : ' . mysqli_connect_error());
    } 
session_start();
//3. If the form is submitted or not.
//3.1 If the form is submitted
if (isset($_POST['username']) and isset($_POST['password'])){
    $password = md5($password);
//3.1.1 Assigning posted values to variables.
$username = $_POST['username'];
$password = $_POST['password'];
$admin = $_POST['admin'];
//3.1.2 Checking the values are existing in the database or not

$query = "SELECT * FROM `login` WHERE username='$username' and password='$password'";
 
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
$count = mysqli_num_rows($result);
//3.1.2 If the posted values are equal to the database values, then session will be created for the user.
if ($count== 1) {
    

if (isset($admin))
{
    $_SESSION['username'] = $user;
    header("location: admin-map.php");
    exit;
} else {
    $_SESSION['username'] = $user;
    header("location: user-map.php");
    exit;
}

}else{
//3.1.3 If the login credentials doesn't match, he will be shown with an error message.
echo  "Invalid Login Credentials.";
}

//3.1.4 if the user is logged in Greets the user with message
if (isset($_SESSION['username'])){
$username = $_SESSION['username'];


}
 
        
}else{

?>
  <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="login.php" method="post">
            <div class="form-group ">
                
                <input type="text" name="username" placeholder="Username" class="form-control" >
                <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" required>
               Admin?:<input type="checkbox" class="form-control" value="1" name="admin"  />
           
            
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            
    </div>    
<?php } ?>
</body>

</html>