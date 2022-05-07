


<?php
    session_start(); 
    require "connection.php";


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




     	<form method="get" enctype="multipart/form-data" >
          
           <input type="file" id="pfp" name="pfp" accept=".png,.git,.jpg" style="display: none;" required/>
          <label style="width: 100%; margin-left: 0%" for="pfp">  <input type="submit" name="upload" value="upload" style="width: 100%; padding: 2px; height: 20%;"></label>
     
       </form>
     	

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