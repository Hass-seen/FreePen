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

            #addes the refreashing capabuilie to the refresh button where the diplay 'all' is to get all posts, and 'word'='' is to filert acording to no words 
          if (isset($_POST['ref'])) {
          	 $_SESSION['posts']='all';
          	 $_SESSION['word']='';
             header('Location: http://localhost/web%20project/home.php');
             die;
          }

        #switches the display option to 'tren' which will affect the selection op posts with ones having the most likes apearing on the top of the post feed 
		if (isset($_POST['tren'])) {
			   $_SESSION['posts']='tren';
			   $_SESSION['word']='';
               header('Location: http://localhost/web%20project/home.php');
               die;
           }

                #switches the 'word' to the one present in the search input so the diplaying of posts will be filtered according to it
               	if (isset($_POST['srch'])) {
				$_SESSION['word']= $_POST['srch'];
				$_SESSION['posts']="all";
				header('Location:http://localhost/web%20project/home.php');
                die;

			}
            #loges the user out of the session sends them to sign in
			if (isset($_POST['logout'])) {
				header('Location:http://localhost/web%20project/sign_in.php');
				session_destroy();
			}

            #chenges the diplay to show only posts by the owner of the session 
			if (isset($_POST['arch'])) {
			   $_SESSION['posts']='arch';
			   $_SESSION['word']='';
               header('Location:http://localhost/web%20project/home.php');
               die;
			}
             #sends the user to the page where they can edit their porfile 
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

 <!--   the dive where the user can create posts  -->
    <div class="poster"> 
        <form method="post" enctype="multipart/form-data">
	      <h4>Subject:</h4>
	      <input type="text" name="subject" id="sub" rows="4" cols="50" required> <br>
	       <h4>Body:</h4>
	       <textarea id="postbody" name="body"  rows="4" cols="50" style="width: 100%" required></textarea><br>
	          <input type="file" id="file" name="pdf" accept=".pdf" style="display: none;" />
   <label style=" cursor: pointer; border-radius: 10px" for="file" > <img src="pdf.png" style="height: 30px; width: 30px"> </label> <br><br>
	       <input type="submit" name="pos" value="post"> <h6 id="alert">pleas fill both inputs*</h6> <label id="cancle">Cancle</label>

        </form>
        <?php
         #addes the post the user created to the database 
        if (isset($_POST['pos'])) {
        	$subject=$_POST['subject'];
        	$body=$_POST['body'];
        	$sub= filter_var($subject, FILTER_SANITIZE_STRING);
        	$bo= filter_var($body, FILTER_SANITIZE_STRING);
        	$mail=$user['email'];
        	$na=$user['name'];
        	$likes=0;
        	$pdf='';
         if($_FILES['pdf']['tmp_name']!=""){
        $file=$_FILES["pdf"];
        $fileName=$_FILES["pdf"]['name'];
        $fileTmpName=$_FILES["pdf"]['tmp_name'];
        $fileSize=$_FILES["pdf"]['size'];
        $fileError=$_FILES["pdf"]['error'];

        $fileExt=explode('.', $fileName);

        $fileActualExt= strtolower(end($fileExt));

        $allowed= array('pdf');

        if (in_array($fileActualExt, $allowed)) {

          if ($fileError===0) {

            $fileNameNew=uniqid('',true).'.'.$fileActualExt;

            $fileDestination='pdfs/'.$fileNameNew;

            move_uploaded_file($fileTmpName, $fileDestination);


        $sql2= "INSERT INTO posts (email,subject,body,likes,pdf,name) VALUES(?,?,?,?,?,?)";
       $stmt2= $conn->prepare($sql2);
       $stmt2->bind_param("sssiss",$mail,$sub,$bo,$likes,$fileDestination,$na);
       $stmt2->execute();
       $posted=$stmt2;
      # header('Location: http://localhost/web%20project/home.php');
      # die;
 

       header('Location: http://localhost/web%20project/home.php'); 
        die;
          }else{
             echo "<script>alert('there was an error uploading your profile picture')</script>";
          }

          
        }else{
          echo "<script>alert('extention incorrect for profile picture')</script>";
        }

      }else{


       $sql2= "INSERT INTO posts (email,subject,body,likes,pdf,name) VALUES(?,?,?,?,?,?)";
       $stmt2= $conn->prepare($sql2);
       $stmt2->bind_param("sssiss",$mail,$sub,$bo,$likes,$pdf,$na);
       $stmt2->execute();
       $posted=$stmt2;
       // header('Location: http://localhost/web%20project/home.php');
       // die;
        header('Location: http://localhost/web%20project/home.php'); 
        die;

        }
    }


        ?>
    </div>





	<header>
		<h3><b class="free">Free</b>dom Pen</h3>
		 <div class="links">
		 	<form method="POST">
		 	<label for="logout" style="cursor: pointer;color: red">logout</label>
		 	<input type="submit" name="logout" id="logout" style="display: none;">
		 	</form>
	</div>
	</header>

   <div class="container" >
   	<!-- user's information is presented in this div -->
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

    <!-- the main diplay of the website -->
	<div class="center" style="overflow-x: hidden;">
		<!-- in this dive the three buttons of post, refresh and zoom are implimented -->
	<div>
		<div class="head" style=" width: 100%">
<form method="post">
			<ul >
				<li style="cursor: pointer;"><img src="zoom.png" id="zoom"></i></li>
				<li><label for="ref" style="cursor: pointer;"><img src="refresh.png" id="refresh"></label></li>
				<input type="submit" name="ref" id="ref" style="display: none;">
				<li style="cursor: pointer;" ><img src="upload.png" id="upload"></li>
			</ul>

</form>
	</div>
	<!-- this is where the posts will be presented to the user -->
		<div class="posts">
             <!-- cheks if the selection of the posts in not empty -->
			<?php if($result->num_rows > 0) {
       #loops for the leangth of the selected posts, and fetches each as an associate arry
  while($row = $result->fetch_assoc()) {
  	#cheks if there is any word that is being searched for
  	if ($_SESSION['word']=='') { 
  		#cheks if the post has an attached PDF file 
  		if ($row['pdf']!='') {
  			        #addes a delete button to the posts made by the user does not if not made by the user
		  			if ($row['email']==$email) {
		  				  		  echo'<div class="feed">
		<a href="visit.php?id='.$row['email'].'" style="color: black"><h2>'.$row['name'].'</h2></a>

		<h6>'.$row['email'].'</h6> <br>
		  <h4>'.$row['subject'].'</h4>
		  <div id="wrapper"><p>'.$row['body'].'</p></div><br><br>
		  <a href="'.$row['pdf'].'" target="_blank"><img src="pdf.png" style="   height: 40px;
		   width: 40px;"></a>
		  <a href="likes.php?id='.$row['id'].'" id="p'.$row['id'].'" style="border-radius: 10px; border:2px black solid; padding:2px 4px; background-color: darkgray" ><span>'.$row['likes'].'</span>
		  <span style="margin-left:10px">upvote</span></a>
          <a href="delete.php?id='.$row['id'].'" id="p'.$row['id'].'" style="border-radius: 10px; border:2px black solid; padding:2px 4px; background-color: darkgray; margin-left: 70%; color: red;" >Delete</a>
		  </div>
		  ';
		  			}else{
		  		  echo'<div class="feed">
		<a href="visit.php?id='.$row['email'].'" style="color: black"><h2>'.$row['name'].'</h2></a>

		<h6>'.$row['email'].'</h6> <br>
		  <h4>'.$row['subject'].'</h4>
		  <div id="wrapper"><p>'.$row['body'].'</p></div><br><br>
		  <a href="'.$row['pdf'].'" target="_blank"><img src="pdf.png" style="   height: 40px;
		   width: 40px;"></a>
		  <a href="likes.php?id='.$row['id'].'" id="p'.$row['id'].'" style="border-radius: 10px; border:2px black solid; padding:2px 4px; background-color: darkgray" ><span>'.$row['likes'].'</span>
		  <span style="margin-left:10px">upvote</span></a></div>';
		      }
  }else{
                 #addes a link that will lead to the attached pdf file, and addes a delete button to the posts done by the user 
		  		if ($row['email']==$email) {
		  			        		  echo'<div class="feed">
		<a href="visit.php?id='.$row['email'].'" style="color: black"><h2>'.$row['name'].'</h2></a>

		<h6>'.$row['email'].'</h6> <br>
		  <h4>'.$row['subject'].'</h4>
		  <div id="wrapper"><p>'.$row['body'].'</p></div><br><br>
		  <a href="likes.php?id='.$row['id'].'" id="p'.$row['id'].'" style="border-radius: 10px; border:2px black solid; padding:2px 4px; background-color: darkgray" ><span>'.$row['likes'].'</span>
		  <span style="margin-left:10px">upvote</span></a>
		  <a href="delete.php?id='.$row['id'].'" id="p'.$row['id'].'" style="border-radius: 10px; border:2px black solid; padding:2px 4px; background-color: darkgray; margin-left: 70%; color: red;" >Delete</a></div>';
		  		}else{
		        		  echo'<div class="feed">
		<a href="visit.php?id='.$row['email'].'" style="color: black"><h2>'.$row['name'].'</h2></a>

		<h6>'.$row['email'].'</h6> <br>
		  <h4>'.$row['subject'].'</h4>
		  <div id="wrapper"><p>'.$row['body'].'</p></div><br><br>
		  <a href="likes.php?id='.$row['id'].'" id="p'.$row['id'].'" style="border-radius: 10px; border:2px black solid; padding:2px 4px; background-color: darkgray" ><span>'.$row['likes'].'</span>
		  <span style="margin-left:10px">upvote</span></a></div>';


		  }

       }

  	}else{
          #filets posts acording to the word present in the session variable "word"
		 if(strpos($row['body'], $_SESSION['word'])!== false){
		 	#cheks if the post has an attached pdf file 
		  		if ($row['pdf']!='') {
		  			#addes a delete button to the posts belonging to the user 
				  			if ($row['email']==$email) {
						  						  		  echo'<div class="feed">
							<a href="visit.php?id='.$row['email'].'" style="color: black"><h2>'.$row['name'].'</h2></a>

							<h6>'.$row['email'].'</h6> <br>
							  <h4>'.$row['subject'].'</h4>
							  <div id="wrapper"><p>'.$row['body'].'</p></div><br><br>
							  <a href="'.$row['pdf'].'" target="_blank"><img src="pdf.png" style="   height: 40px;
							   width: 40px;"></a>
							  <a href="likes.php?id='.$row['id'].'" id="p'.$row['id'].'" style="border-radius: 10px; border:2px black solid; padding:2px 4px; background-color: darkgray" ><span>'.$row['likes'].'</span>
							  <span style="margin-left:10px">upvote</span></a>
							  <a href="delete.php?id='.$row['id'].'" id="p'.$row['id'].'" style="border-radius: 10px; border:2px black solid; padding:2px 4px; background-color: darkgray; margin-left: 70%; color: red;" >Delete</a></div>';
				  			}else{
				  		  echo'<div class="feed">
				<a href="visit.php?id='.$row['email'].'" style="color: black"><h2>'.$row['name'].'</h2></a>

				<h6>'.$row['email'].'</h6> <br>
				  <h4>'.$row['subject'].'</h4>
				  <div id="wrapper"><p>'.$row['body'].'</p></div><br><br>
				  <a href="'.$row['pdf'].'" target="_blank"><img src="pdf.png" style="   height: 40px;
				   width: 40px;"></a>
				  <a href="likes.php?id='.$row['id'].'" id="p'.$row['id'].'" style="border-radius: 10px; border:2px black solid; padding:2px 4px; background-color: darkgray" ><span>'.$row['likes'].'</span>
				  <span style="margin-left:10px">upvote</span></a></div>';
				     }
		      }else{ #addes a link leading to the PDF attached to the post and a delete button if the post was made by the user 
				      	if ($row['email']==$email) {
				      				        		  echo'<div class="feed">
				<a href="visit.php?id='.$row['email'].'" style="color: black"><h2>'.$row['name'].'</h2></a>

				<h6>'.$row['email'].'</h6> <br>
				  <h4>'.$row['subject'].'</h4>
				  <div id="wrapper"><p>'.$row['body'].'</p></div><br><br>
				  <a href="likes.php?id='.$row['id'].'" id="p'.$row['id'].'" style="border-radius: 10px; border:2px black solid; padding:2px 4px; background-color: darkgray" ><span>'.$row['likes'].'</span>
				  <span style="margin-left:10px">upvote</span></a>
				  <a href="delete.php?id='.$row['id'].'" id="p'.$row['id'].'" style="border-radius: 10px; border:2px black solid; padding:2px 4px; background-color: darkgray; margin-left: 70%; color: red;" >Delete</a></div>';
				      	}else{
				        		

				        		  echo'<div class="feed">
				<a href="visit.php?id='.$row['email'].'" style="color: black"><h2>'.$row['name'].'</h2></a>

				<h6>'.$row['email'].'</h6> <br>
				  <h4>'.$row['subject'].'</h4>
				  <div id="wrapper"><p>'.$row['body'].'</p></div><br><br>
				  <a href="likes.php?id='.$row['id'].'" id="p'.$row['id'].'" style="border-radius: 10px; border:2px black solid; padding:2px 4px; background-color: darkgray" ><span>'.$row['likes'].'</span>
				  <span style="margin-left:10px">upvote</span></a></div>';


		}
	}



		}
		  	
		  	}

  }
}


?>
  
   </div>

</div>
		
	</div>
     <!-- the option bar of the website  -->
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