


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
 
   	
   <div class="stuff">


              <img src=<?php echo "".$user['pfp']."";?>>     




     	<form method="post" enctype="multipart/form-data" >
          
           <input type="file" id="pfp" name="pfp" accept=".png,.git,.jpg" style="display: none;" required/>
          <label style="width: 100%; margin-left: 16%; border-radius: 10px; background-color: white; padding: 2px; margin-bottom: 4px; cursor: pointer;" for="pfp" > change image </label>
          <input type="submit" name="upl" value="upload" style="width: 100%; padding: 2px; height: 20%; margin-top: 4px;">
     
       </form>
       <?php 

      if (isset($_POST['upl'])) {


        $image=$_FILES["pfp"]["tmp_name"];
        $PFP    = file_get_contents($image);
        $sql = 'UPDATE user SET pfp='.$PFP.' WHERE email="'.$user['email'].'"';



      }
       ?>
     	

       <label for="fname" class="red">First name: </label>  
  <input type="text" id="fname" name="fname">

  <label for="lname" class="red">Last name:</label>  
  <input type="text" id="lname" name="lname">

  <label for="status" class="red">Status:</label>  
  <input type="text" id="status" name="status">

  <label for="cov" class="red">Field of covrage:</label>  
  <input type="text" id="cov" name="cov">


  <label for="bio" class="red">Biofraphy</label>  
  <input type="text" id="bio" name="bio">

  <button>Done</button>



</div>

   




</body>
</html>