<?php
session_start();

require "connection.php";

$id =(int) $_GET['id']; #gets the id of the post form the URL 

	$sq = "DELETE FROM post_likes WHERE post=? "; 
	$st = $conn->prepare($sq); 
    $st->bind_param("i", $id);
    $st->execute(); #delets all entreis of the post form the post_likes table 


    $sql = "DELETE FROM posts WHERE id=? ";
	$stm = $conn->prepare($sql); 
    $stm->bind_param("i", $id);
    $stm->execute();#delets the post from the posts table 

 header('Location:http://localhost/web%20project/home.php');
     die;

    ?>