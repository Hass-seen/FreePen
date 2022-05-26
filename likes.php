<?php
session_start();
require "connection.php";


$email=$_SESSION['email'];
$id =(int) $_GET['id'];
 
   $sql= "INSERT INTO post_likes (email,post) VALUES(?,?)";
     $stmt = $conn->prepare($sql); 
     $stmt->bind_param("si", $email,$id);
     $stmt->execute();
     $result = $stmt->get_result();


if ($conn -> affected_rows>0) {
	$x="UPDATE posts SET likes = likes + 1 WHERE id = ? ";
	$s = $conn->prepare($x); 
    $s->bind_param("i", $id);
    $s->execute();
}else{
	$sq = "DELETE FROM post_likes WHERE email= ? AND post=? ";
	$st = $conn->prepare($sq); 
    $st->bind_param("si", $email,$id);
    $st->execute();


	$z="UPDATE posts SET likes = likes - 1 WHERE id = ? ";
	$f = $conn->prepare($z); 
    $f->bind_param("i", $id);
    $f->execute();


}




 header('Location:http://localhost/web%20project/home.php');
     die;

?>

	