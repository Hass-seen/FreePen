


<?php
    session_start(); 
    require "connection.php";

     $email=$_SESSION['email'];
 $sql = "SELECT * FROM user WHERE email=?"; 
$stmt = $conn->prepare($sql); 
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result(); 
$user = $result->fetch_assoc();
$name= explode(" " , $user['name'])


?>




<!DOCTYPE html>
<html>
<head>
	<title>Profile Edit</title>


	<link rel="stylesheet" type="text/css" href="edit.css">
</head>
<body>


<header>
		<h3><b class="free">Free</b>dom Pen</h3>
		 <div class="links">
		 	<a href="">contact us</a>
	</div>
	</header>
 <form method="post" enctype="multipart/form-data">
   	<script type="text/javascript">
    function  selectimage(e){
      var file=e.target.files[0]
        console.log(file)
        console.log(typeof(file))
      }
    </script>
   <div class="stuff">


   <img src=<?php echo "".$user['pfp']."";?>>     




     	
        
   <input type="file" id="pfp" name="pfp" accept=".png,.git,.jpg" style="display: none;"onchange="selectimage(event)" />
   <label style=" border-radius: 10px; background-color: white; padding: 2px; margin-bottom: 4px; cursor: pointer;" for="pfp" > change image </label>    
   <label for="fname" class="red">First name: </label>  
  <input type="text" style="padding: 3px;" id="fname" name="fname" required value=<?php echo $name[0];?>>

  <label for="lname" class="red">Last name:</label>  
  <input type="text" style="padding: 3px;" id="lname" name="lname" required value=<?php echo $name[1];?>>

  <label for="status" class="red">Status:</label>  
  <input type="text" style="padding: 3px;" id="status" name="status" required value=<?php echo $user['status'];?>>

  <label for="cov" class="red">Field of covrage:</label>  
  <textarea id="cov" name="cov"  rows="4" cols="50" required style="border-radius: 10px; padding: 3px;"><?php echo $user['status']?></textarea><br>


  <label for="bio" class="red">Biofraphy</label>  
  <textarea id="bio" name="bio"  rows="4" cols="50" required style="border-radius: 10px;padding: 3px;"><?php echo $user['bio']?></textarea><br>

  <input type="submit" name="go" value="Save">



</div>

   </form>
   <?php

    if(isset($_POST['go'])){
      

      $fname= $_POST['fname'];
      $lname= $_POST['lname'];
      $name=$fname ." ".$lname;
      $name   = filter_var($name, FILTER_SANITIZE_STRING);
      $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
      $bio =    filter_var($_POST['bio'], FILTER_SANITIZE_STRING); 
      $feild = filter_var($_POST['cov'], FILTER_SANITIZE_STRING);

      if(file_get_contents($_FILES['pfp']['tmp_name'])!=""){
        $PFP= file_get_contents($_FILES["pfp"]["tmp_name"]);

        $sql = 'UPDATE user SET name=?, status=?, bio=?, field=?, pfp=?  WHERE email=?';
        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("ssssbs",$name,$status,$bio,$feild,$PFP, $email);
        $stmt->execute(); 

      

      }else{


       $sql = 'UPDATE user SET name=?, status=?, bio=?, field=?, WHERE email=?';
       $stmt = $conn->prepare($sql); 
        $stmt->bind_param("ssssbs",$name,$status,$bio,$feild, $email);
        $stmt->execute(); 

      }



    }


   ?>




</body>
</html>