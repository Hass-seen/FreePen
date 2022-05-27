<?php

$email=$_GET['id'];
require "connection.php";

 $sql = "SELECT * FROM user WHERE email=?"; 
$stmt = $conn->prepare($sql); 
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result(); 
$user = $result->fetch_assoc();


	$sql = "SELECT * FROM posts WHERE email= '$email' ORDER BY id DESC";
	$result = $conn->query($sql);


?>




<!DOCTYPE html>
<html>
<head>
	<title>visit</title>
	<link rel="stylesheet" type="text/css" href="home.css">
	<script src="jquery-3.6.0.min.js"></script>
</head>
<body>
	<header>
		<h3><b class="free">Free</b>dom Pen</h3>
		 <div class="links">
		 	<a href="">contact us</a>
	</div>
	</header>

   <div class="container" >
		<div class="left" >
		<?php echo '<img src="'.$user['pfp'].'" class="pfp">';?>
	 
        <div class="personal">
        	<div class="status">
        		<h6>Name :</h6>
         <p><?php echo $user['name']?></p>
         <h6>Status :</h6>
         <p><?php echo $user['status']?></p>

         <h5>Field of covrage: </h5>
         <p><?php echo $user['field']?></p>
          </div>

          <div class="bio">
         <h6>Biography :</h6>
         <p> <?php echo $user['bio']?> </p>
          </div>
         </div>


	</div>


	<div class="center">
	<div>
		<div class="head" style="width: 100%">

			<ul>
				<li><img src="zoom.png" id="zoom"></i></li>
		
			</ul>


		</div>
		<div class="posts">
<?php

 if($result->num_rows > 0) {

  while($row = $result->fetch_assoc()) {
  		  echo'<div class="feed">
<a href="visit.php?id='.$row['email'].'" style="color: black"><h2>'.$row['name'].'</h2></a>

<h6>'.$row['email'].'</h6> <br>
  <h4>'.$row['subject'].'</h4>
  <div id="wrapper"><p>'.$row['body'].'</p></div>
 <a href="likes.php?id='.$row['id'].'" id="p'.$row['id'].'" style="border-radius: 10px; border:2px black solid; padding:2px 4px; background-color: darkgray" ><span>'.$row['likes'].'</span>
  <span style="margin-left:10px">upvote</span></a></div>' ;

  }}

?>
   </div>
</div>
		
	</div>

	

    </div>




<script src="home.js"></script>
</body>
</html>