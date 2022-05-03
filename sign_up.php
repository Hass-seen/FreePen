
<?php

session_start();
require "connection.php";

 ?>




<!DOCTYPE html>
<html>
<head>
	<title>Sign up</title>
    <link rel="stylesheet" href="sign_up.css">
    <script src="jquery-3.6.0.min.js"></script>
    </head>
<body>

   <div>
  <?php
     

     if (isset($_POST['go'])) {
        $fname= $_POST['firstname'];
        $lname= $_POST['lastname'];
      
       $name=$fname ." ".$lname;
       $Em = $_POST['E-Mail'];
       $passwo= $_POST['Password'];


       $nmae = filter_var($name, FILTER_SANITIZE_STRING);
       $email= filter_var($Em, FILTER_SANITIZE_EMAIL);
       $pass = filter_var($passwo, FILTER_SANITIZE_STRING);


       $sql= "INSERT INTO user (email,name,password,status,field,bio,pfp) VALUES(?,?,?,?,?,?,?)";

     
     }


    ?>
</div>
    
<header>
    <h3><b class="free">Free</b>dom Pen</h3>
     <div class="links">
      <a href="">contact us</a>
  </div>
  </header>


	
    <div class="signe-up">

	<form method="post">

		<label for="firstname" class="red">First Name</label> 

  <input type="text" id="firstname" name="firstname" class="clear" required>

  <label for="lastname" class="red">Last Name</label>  

  <input type="text" id="lastname" name="lastname" class="clear" required>

  <label for="E-Mail" class="red">E-Mail</label>  

  <input type="email" id="email" name="E-Mail" class="clear" required>

  <label for="Password" class="red">Password</label>

  <input type="password" id="pass" name="Password" class="clear" required>


  <input class="button" type="submit" value="Sign up" name="go">
  </form>


    </div>

    

   


   
 


</script>
</body>
</html>