<?php

session_start();

include 'connect.php';
$user = 0;
$success = 0;

if($_SERVER['REQUEST_METHOD'] === 'POST'){
   $username = $_POST['username'];
   $password = $_POST['password'];

   if(isset($_POST['submit']) && $username && $password){
      $username = textfilter($username);
      $password = MD5(textfilter($password));
    //   echo $username,$password;
      
     

    $sql = "SELECT * FROM register where username='$username'";
    $result = mysqli_query($conn,$sql);
    if($result){
        $num = mysqli_num_rows($result);
        if($num > 0){
            // echo "User Already Exists";
            $user = 1;
        }else{
            $stmt = "INSERT INTO register(username,password)
            VALUES (?,?)";
            $insertstmt = mysqli_prepare($conn,$stmt);
            mysqli_stmt_bind_param($insertstmt,'ss',$user,$pass);
            $user = $username;
            $pass = $password;
            if(mysqli_stmt_execute($insertstmt)){
                   // echo "Sign Up Successfully ";
               $success = 1;

               $_SESSION['username'] = $username;
               $_SESSION['password'] = $password;
               header("Location:home.php");
            }
           
        }

        $conn->close();
    }
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
    <title>Sign Up Page</title>
  </head>
  <body>

    <?php
        if($user){
            echo "
            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
             <strong>Ohh Sorry!</strong> User Already Exists !!!
             <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
           </div>
            ";
        }
    ?>

    <?php
        if($success){
            echo "
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
             <strong>Successs!</strong> You are successfully signup !!!
             <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
           </div>
            ";
        }
    ?>

    <div class="container mt-5">
        <h1 class="text-center">Sign Up Page</h1>
        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" >
           <div class="mb-3">
              <label for="username" class="form-control">Username</label>
              <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" />
          </div>
          <div class="mb-3">
             <label for="password" class="form-label">Password</label>
             <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" />
          </div>
 
          <button type="submit" name="submit" class="btn btn-primary">Sign Up</button>
       </form>
         
    </div>

    <!-- Bootstrap css1 js1 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>