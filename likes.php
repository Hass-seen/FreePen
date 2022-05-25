<?php if (isset($_GEt['id'])){
session_start();
require "connection.php";
$email=$_SESSION['email'];
$id =(int)$_GEt['id'];
 
conn->query("
	INSERT INTO post_likes (user,post)
		SELECT {$email},{$id}
		FROM posts 
		WHERE EXISTS (

			SELECT id
			FROM posts 
			WHERE id={$id})
		AND NOT EXISTS (
			SELECT id 
			FROM post_likes
			WHERE user={$email})
			AND post={$id})
		LIMIT 1

	")





} 


				header('Location:http://localhost/web%20project/home.php');
                die;

?>
	