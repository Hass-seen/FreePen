<?php
session_start();

require "connection.php";

$id =(int) $_GET['id'];

	$sq = "DELETE FROM post_likes WHERE post=? ";
	$st = $conn->prepare($sq); 
    $st->bind_param("i", $id);
    $st->execute();


    $sql = "DELETE FROM posts WHERE id=? ";
	$stm = $conn->prepare($sql); 
    $stm->bind_param("i", $id);
    $stm->execute();

 header('Location:http://localhost/web%20project/home.php');
     die;

    ?>