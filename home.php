<?php

session_start();
require "connection.php";

   $email=$_SESSION['email'];
 $sql = "SELECT * FROM user WHERE email=?"; 
$stmt = $conn->prepare($sql); 
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result(); 
$user = $result->fetch_assoc();
        


?>


<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="home.css">
	<script src="jquery-3.6.0.min.js"></script>
</head>
<body>


 <?php

if(array_key_exists('post', $_POST)) {
            button1();
        }

 function button1() {
            echo "This is Button1 that is selected";
        }
 ?>
  
    <div class="poster"> 
        <form method="post">
	      <h4>Subject:</h4>
	      <input type="text" name="subject" id="sub"> <br>
	       <h4>Body:</h4>
	       <textarea id="postbody" name="body" rows="4" cols="50"></textarea><br>
	       <button name="post">post</button> <h6 id="alert">pleas fill both inputs*</h6> <label id="cancle">Cancle</label>

        </form>
    </div>




	<header>
		<h3><b class="free">Free</b>dom Pen</h3>
		 <div class="links">
		 	<a href="">contact us</a>
	</div>
	</header>

   <div class="container" >
	<div class="left" >
		<img src="pfp.png" class="pfp">
        <div class="personal">
        	<div class="status">
        		<h6>Name :</h6>
         <p><?php echo $user['name']?></p>
         <h6>Status :</h6>
         <p>its a good day for a free lancer</p>

         <h5>Field of covrage: </h5>
         <p>im not a reporter, im just making this website</p>
          </div>

          <div class="bio">
         <h6>Biography :</h6>
         <p> Former Physics studant, tried my luck for 4 years, <br>
          dropped out and then movoed to combuter sience <br>
          and i feel im doing well, though web development is breaking my brain  </p>
          </div>
         </div>


	</div>


	<div class="center">
	<div>
		<div class="head">

			<ul>
				<li><img src="zoom.png" id="zoom"></i></li>
				<li><img src="refresh.png" id="refresh"></li>
				<li><img src="upload.png" id="upload"></li>
			</ul>


		</div>
		<div class="posts">
			
  
   </div>
</div>
		
	</div>

	<div class="right">
		<ul>
			<li class="sub" id="trend">Treding</li>
			<div class="search">
			<li class="sub" >Search</li>
			  <input type="text" id="srch" name="srch">
             </div>
              <div class="list1">

			<li class="sub">Notifications</li>
            <ul class="submen"><li>notif1</li>
				              <li>notif2</li>
				              <li>notif2</li>

			</ul>
             </div>

			<li class="sub">My Archives</li>
			<li class="sub">Edit Profile</li>
			<div class="list1">
			<li class="sub">Subscriptions</li>


			<ul class="submen"><li>person1</li>
				              <li>person2</li>

			</ul>
			</div>
			

		</ul>
	</div>

    </div>




<script src="home.js"></script>
</body>
</html>