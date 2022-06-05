<?php
session_start();
require "connection.php";


$email=$_SESSION['email'];
$id =(int) $_GET['id'];#gets the id of the post from the URl 
    
   $sql= "INSERT INTO post_likes (email,post) VALUES(?,?)";
     $stmt = $conn->prepare($sql); 
     $stmt->bind_param("si", $email,$id);
     $stmt->execute();#inserts the email of the user and the id of the post in the table post_likes 
     $result = $stmt->get_result();

#cheks if the previose query affected any rows 
if ($conn -> affected_rows>0) {
	$x="UPDATE posts SET likes = likes + 1 WHERE id = ? ";
	$s = $conn->prepare($x); 
    $s->bind_param("i", $id);
    $s->execute();#addes a like to the likes field of the post 
}else{
	$sq = "DELETE FROM post_likes WHERE email= ? AND post=? ";
	$st = $conn->prepare($sq); 
    $st->bind_param("si", $email,$id);
    $st->execute();#delets the entry having the same email and id 


	$z="UPDATE posts SET likes = likes - 1 WHERE id = ? ";
	$f = $conn->prepare($z); 
    $f->bind_param("i", $id);
    $f->execute();#subtracts a like from the likes field of the post 


}




 header('Location:http://localhost/web%20project/home.php');
     die;

?>

	