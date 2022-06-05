
<?php

session_start();
require "connection.php";
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>signe in</title>
	<link rel="stylesheet" href="sign_in.css">
  <style type="text/css">
    body{
  size: 100%;
  height: 100%;
  background-image: url(sign-in.jpg);
  background-size: cover;
  background-repeat: no-repeat;
}

  </style>

</head>
<body>

<header>
		<h3><b class="free">Free</b>dom Pen</h3>
		 <div class="links">
      <a href="sign_up.php" id="sign-up">Sign up</a>
	</div>
	</header>
	</header>
    <div class="signe-in">
	<form method="post">
  <label for="E-Mail" class="red">E-Mail</label>  
  <input type="text" id="E-Mail" name="E-Mail">
  <label for="Password" class="red">Password</label>
  <input type="text" id="" name="Password">
  <input class="button" type="Submit" name="in" value="Log in">
  </form>
<?php 


if (isset($_POST['in'])) {
	         $Em = $_POST['E-Mail'];
	         $pass= $_POST['Password'];

        $email  = filter_var($Em, FILTER_SANITIZE_EMAIL);
        $pass= filter_var($pass,  FILTER_SANITIZE_STRING);

         $sql = "SELECT * FROM user WHERE email=?"; 
         $stmt = $conn->prepare($sql); 
         $stmt->bind_param("s", $email);
         $stmt->execute();
         $result = $stmt->get_result(); 
         $user = $result->fetch_assoc();

         if(isset($user['email'])!=Null){
             #$password=$user['password'];
         	if (password_verify($pass,$user['password'])) {
         		       $_SESSION['email']=$email;
                   $_SESSION['posts']='all';
                   $_SESSION['word']='';
             header('Location: http://localhost/web%20project/home.php');
             die;
         	}else{
                     echo "<script>alert('incorrect password');</script>";
          header('Location: http://localhost/web%20project/sign_in.php');
             die;
         	}

         }else{
         echo "<script>alert('Account does not exist pleas sign up first');
document.getElementById('sign-up').style.color = '#DC143C';
         </script>";
         }
}


?>



    </div>
    <div style="height: 30vh">
      


    </div>
</body>
</html>