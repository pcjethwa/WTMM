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

//get favorite post by user_id
if(isset($_POST["type"]) && $_POST["type"] == "favorite")
{
	$posts = array();
	$obj->query="select p.*,i.image_url as image,i.thumb_url as thumb from favorite as f INNER JOIN posts as p on f.post_id = p.id LEFT JOIN images as i ON i.post_id = p.id WHERE f.user_id = '".$_POST['usr_id']."'";
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
			'message' => 'No Favorite post found.'
			);
	}
}

//add favorite
if(isset($_POST["type"]) && $_POST["type"] == "add_favorite")
{
	$obj->query="INSERT INTO favorite('user_id','post_id','created_at','updated_at') VALUES('".$_POST['user_id']."','".$_POST['post_id']."','NOW()','NOW()')";
	$insert_id = $obj->insert_with_id($obj->query);
	
	if($insert_id)
	{
		$returnArray = array(
			'status' => 'success',
			'insert_id' => $insert_id
			);
	}else
	{
		$returnArray = array(
			'status' => 'error',
			'message' => 'Unable to add favorite.'
			);
	}
}

//delete favorite
if(isset($_POST["type"]) && $_POST["type"] == "delete_favorite")
{
	$obj->query="delete from favorite WHERE user_id = '".$_POST['user_id']."' AND post_id = '".$_POST['post_id']."'";
	
	if($obj->update_delete($obj->query))
	{
		$returnArray = array(
		'status' => 'success',
		);
	}else
	{
		$returnArray = array(
			'status' => 'error',
			'message' => 'Unable to delete favorite.'
			);
	}
}
echo json_encode($returnArray);
exit;
?>