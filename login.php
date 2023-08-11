<?php

$login = 0;
$invalid = 0;

include 'connect.php';
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
   $username = textfilter($_POST['username']);
   $password = MD5(textfilter($_POST['password']));
//    echo $password;

   $query = "SELECT username,password  FROM register WHERE username = ? AND password = ?";
   $stmt = mysqli_prepare($conn,$query);

   mysqli_stmt_bind_param($stmt,'ss',$user,$pass);
   $user = $username;
   $pass = $password;
   mysqli_stmt_execute($stmt);
   
   $result = mysqli_stmt_get_result($stmt);
   if(mysqli_num_rows($result) > 0){
    //  echo "Login Successful";
    $login = 1;
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    header("Location:home.php");
 
 }else{
    // echo "Invalid data";
    $invalid = 1;
 }

   
}

function textfilter($data){
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $data;
}


?>
<!DOCTYPE HTML>
<html>
  <head>
    <!-- Bootstrap css1 js1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Login Page</title>
  </head>
  <body>

  <?php
        if($login){
            echo "
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
             <strong>Success!</strong> You are successfull login !!!
             <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
           </div>
            ";
        }
    ?>

 <?php
        if($invalid){
            echo "
            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
             <strong>Error!</strong> Invalid Credentials !!!
             <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
           </div>
            ";
        }
    ?>

    <div class="container mt-5">
        <h1 class="text-center">Login Page</h1>
        <form action="login.php" method="POST" >
           <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" />
          </div>
          <div class="mb-3">
             <label for="password" class="form-label">Password</label>
             <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" />
          </div>
 
          <button type="submit" class="btn btn-primary">Login</button>

          <div class="mt-3">
             <h5>Don't have account <a href="signup.php">Sign Up Here !!</a></h5>
          </div>
       </form>
         
    </div>

    <!-- Bootstrap css1 js1 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>