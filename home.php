<?php

session_start();
require "connection.php";

   $email=$_SESSION['email'];
   $display=$_SESSION['posts'];
 $sql = "SELECT * FROM user WHERE email=?"; 
$stmt = $conn->prepare($sql); 
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result(); 
$user = $result->fetch_assoc();

if ($display=='all') {
	$sql = "SELECT * FROM posts ORDER BY id DESC";
$result = $conn->query($sql);
}else if ($display=='arch') {
	$sql = "SELECT * FROM posts WHERE email= '$email' ORDER BY id DESC";
	$result = $conn->query($sql);
 
}else if ($display=='tren') {
	$sql = "SELECT * FROM posts WHERE likes>0 ORDER BY likes DESC";
	$result = $conn->query($sql);
}

     
          if (isset($_POST['ref'])) {
          	 $_SESSION['posts']='all';
          	 $_SESSION['word']='';
             header('Location: http://localhost/web%20project/home.php');
             die;
          }

		if (isset($_POST['tren'])) {
			   $_SESSION['posts']='tren';
               header('Location: http://localhost/web%20project/home.php');
               die;
           }


               	if (isset($_POST['srch'])) {
				$_SESSION['word']= $_POST['srch'];
				$_SESSION['posts']="all";
				header('Location:http://localhost/web%20project/home.php');
                die;

			}

			if (isset($_POST['arch'])) {
			   $_SESSION['posts']='arch';
               header('Location:http://localhost/web%20project/home.php');
               die;
			}

			 if (isset($_POST['edit'])) {
              	     $_SESSION['email']=$email;
                     header('Location:http://localhost/web%20project/edit.php');
                     die; 
              }   


?>


<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="home.css">
	<script src="jquery-3.6.0.min.js"></script>
</head>
<body>

  
    <div class="poster"> 
        <form method="post">
	      <h4>Subject:</h4>
	      <input type="text" name="subject" id="sub" rows="4" cols="50" required> <br>
	       <h4>Body:</h4>
	       <textarea id="postbody" name="body"  rows="4" cols="50" required></textarea><br>
	       <input type="submit" name="post" value="post"> <h6 id="alert">pleas fill both inputs*</h6> <label id="cancle">Cancle</label>

        </form>
        <?php

        if (isset($_POST['post'])) {
        	$subject=$_POST['subject'];
        	$body=$_POST['body'];
        	$sub= filter_var($subject, FILTER_SANITIZE_STRING);
        	$bo= filter_var($body, FILTER_SANITIZE_STRING);
        	$mail=$user['email'];
        	$na=$user['name'];
        	$likes=0;
        	$pdf='';

       $sql2= "INSERT INTO posts (email,subject,body,likes,pdf,name) VALUES(?,?,?,?,?,?)";
       $stmt2= $conn->prepare($sql2);
       $stmt2->bind_param("sssiss",$mail,$sub,$bo,$likes,$pdf,$na);
       $stmt2->execute();
       $posted=$stmt2;
       header('Location: http://localhost/web%20project/home.php');
       die;

        }


        ?>
    </div>





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


	<div class="center" style="overflow-x: hidden;">
	<div>
		<div class="head" style=" width: 100%">
<form method="post">
			<ul >
				<li style="cursor: pointer;"><img src="zoom.png" id="zoom"></i></li>
				<li><label for="ref" style="cursor: pointer;"><img src="refresh.png" id="refresh"></label></li>
				<input type="submit" name="ref" id="ref" style="display: none;">
				<li style="cursor: pointer;"><img src="upload.png" id="upload"></li>
			</ul>

</form>
	</div>
		<div class="posts">

			<?php if($result->num_rows > 0) {

  while($row = $result->fetch_assoc()) {
  	if ($_SESSION['word']=='') {
  		  echo'<div class="feed">
<a href="visit.html?id='.$row['email'].'" style="color: black"><h2>'.$row['name'].'</h2></a>

<h6>'.$row['email'].'</h6> <br>
  <h4>'.$row['subject'].'</h4>
  <div id="wrapper"><p>'.$row['body'].'</p></div>
  <button id="button" class="like-btn"><span>'.$row['likes'].'</span>
  <span style="margin-left:10px">upvote</span></button></div>' ;
  	}else{

		 if(strpos($row['body'], $_SESSION['word'])!== false){
		      		  echo'<div class="feed">

       <a href="visit.html?id='.$row['email'].'" style="color: black"><h2>'.$row['name'].'</h2></a>
					<h6>'.$row['email'].'</h6> <br>
					  <h4>'.$row['subject'].'</h4>
					  <div id="wrapper"><p>'.$row['body'].'</p></div>
					  <button id="button" class="like-btn"><span>'.$row['likes'].'</span>
					  <span style="margin-left:10px">upvote</span></button></div>' ;
		}
		  	
		  	}

  }
  $_SESSION['word']='';
}


?>
  
   </div>

</div>
		
	</div>

	<div class="right" style="	height: 50vh;">
		<form method="post" >
		<ul>
			<li class="sub" id="trend"><label for="tren" style="cursor: pointer">Treding</label></li>
			<input type="submit" name="tren" id="tren" style="display: none;">
			</form>

			<form method="post">
			<div class="search">
			<li class="sub" >Search</li>
			  <input type="text" id="srch" name="srch">
             </div>
              <div class="list1">
			</form>

             </div>

			<li class="sub"><label for="arch" style="cursor: pointer">My Posts</label></li>
			<input type="submit" name="arch" id="arch" style="display: none;">
			<form method="post">
			<li class="sub"><label for="edit" style="cursor: pointer;">Edit Profile</label> <input type="submit" name="edit" id="edit" style="display: none;"></li>
			
			</form>
			<div class="list1">

			</div>
			

		</ul>
	</div>

    </div>




<script src="home.js"></script>
</body>
</html>