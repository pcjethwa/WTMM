<?php
	session_start();
	include_once("../inc/connection.php");
	$obj=new connection();
	$obj->connect();
	 $returnArray = array();
if(isset($_POST["type"]) && $_POST["type"] == "all")
{
	$posts = array();
	$obj->query="select p.*,i.image_url as image,i.thumb_url as thumb from posts as p LEFT JOIN images as i ON i.post_id = p.id";
	$obj->select($obj->query);
	$no = mysqli_num_rows($obj->result);
	if($no > 0)
	{
		while($result = mysqli_fetch_assoc($obj->result)){
			$posts[] = $result;
		}
		$returnArray = array(
			'status' => 'success',
			'posts' => $posts
			);
	}else
	{
		$returnArray = array(
			'status' => 'error',
			'message' => 'No posts found'
			);
	}
}

if(isset($_POST["type"]) && $_POST["type"] == "id")
{
	$posts = array();
	$obj->query="select p.*,i.image_url as image,i.thumb_url as thumb from posts as p LEFT JOIN images as i ON i.post_id = p.id WHERE p.id = '".$_POST['post_id']."'";
	$obj->select($obj->query);
	$no = mysqli_num_rows($obj->result);
	if($no > 0)
	{
		$post = mysqli_fetch_assoc($obj->result);
		$returnArray = array(
			'status' => 'success',
			'posts' => $post
			);
	}else
	{
		$returnArray = array(
			'status' => 'error',
			'message' => 'No post found.'
			);
	}
}
echo json_encode($returnArray);
exit;
?>