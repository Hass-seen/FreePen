


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
   <div class="stuff">


   <img src=<?php echo "".$user['pfp']."";?>>     




     	
        
   <input type="file" id="pfp" name="pfp" accept=".png,.git,.jpg" style="display: none;"onchange="selectimage(event)" />
   <label style=" border-radius: 10px; background-color: white; padding: 2px; margin-bottom: 4px; cursor: pointer;" for="pfp" > change image </label>    <br>
   <label for="fname" class="red">Full name: </label>  
  <input type="text" style="padding: 3px;" id="fname" name="fname" >

  <label for="status" class="red">Status:</label>  
  <input type="text" style="padding: 3px;" id="status" name="status" >

  <label for="cov" class="red">Field of covrage:</label>  
  <textarea id="cov" name="cov"  rows="4" cols="50" style="border-radius: 10px; padding: 3px; width: 40%"></textarea><br>


  <label for="bio" class="red">Biofraphy</label>  
  <textarea id="bio" name="bio"  rows="4" cols="50" style="border-radius: 10px;padding: 3px; width: 40%"></textarea><br>

  <input type="submit" name="go" value="Save">



</div>

   </form>
   <?php

    if(isset($_POST['go'])){
      


      if ($_POST['fname']!='') {
        $name= $_POST['fname'];
      }else{
        $name=$user['name'];
      }
      if ($_POST['status']!='') {
        $sta=$_POST['status'];
      }else{
        $sta=$user['status'];
      }
      if($_POST['bio']!=''){
        $b=$_POST['bio'];

      }else{
        $b=$user['bio'];
      }
      if ($_POST['cov']!='') {
        $fe=$_POST['cov'];
      }else{
        $fe=$user['field'];
      }

      
      
      
      $name   = filter_var($name, FILTER_SANITIZE_STRING);
      $status = filter_var($sta, FILTER_SANITIZE_STRING);
      $bio =    filter_var($b, FILTER_SANITIZE_STRING); 
      $feild = filter_var($fe, FILTER_SANITIZE_STRING);
     #cheks if the user uploaded an image 
      if($_FILES['pfp']['tmp_name']!=""){
        $file=$_FILES["pfp"];
        $fileName=$_FILES["pfp"]['name'];
        $fileTmpName=$_FILES["pfp"]['tmp_name'];
        $fileSize=$_FILES["pfp"]['size'];
        $fileError=$_FILES["pfp"]['error'];

        $fileExt=explode('.', $fileName);

        $fileActualExt= strtolower(end($fileExt));

        $allowed= array('jpg','jpeg','png');
        #cheks is the uploaded file isof the correct type 
        if (in_array($fileActualExt, $allowed)) {

          if ($fileError===0) {

            $fileNameNew=uniqid('',true).'.'.$fileActualExt;

            $fileDestination='pfps/'.$fileNameNew;

            move_uploaded_file($fileTmpName, $fileDestination);

            #updates the feidls acording to the imputed information 
        $sql = 'UPDATE user SET name=?, status=?, bio=?, field=?, pfp=?  WHERE email=?';
        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("ssssss",$name,$status,$bio,$feild,$fileDestination, $email);
        $stmt->execute(); 

                header('Location: http://localhost/web%20project/home.php'); 
                 die;
          }else{
             echo "<script>alert('there was an error uploading your profile picture')</script>";
          }

          
        }else{
          echo "<script>alert('extention incorrect for profile picture')</script>";
        }

      }else{


       $sql = 'UPDATE user SET name=?, status=?, bio=?, field=? WHERE email=?';
       $stmt = $conn->prepare($sql); 
        $stmt->bind_param("sssss",$name,$status,$bio,$feild, $email);
        $stmt->execute();

        header('Location: http://localhost/web%20project/home.php'); 
        die;

      }



    }


   ?>




</body>
</html>