<?php
	session_start();
	include_once("../inc/connection.php");
	$obj=new connection();
	$obj->connect();
	 
if(isset($_POST["access_token"]))
{
	$email = mysqli_real_escape_string($obj->con, $_POST["email_address"]);
	$obj->query="select * from users where email_id='".email."'";
	$obj->select($obj->query);
	$no = mysqli_num_rows($obj->result);
	$user = mysqli_fetch_assoc($obj->result);
	if($no > 0)
	{
		$sql_query = "UPDATE users set 
							first_name = '".mysqli_real_escape_string($obj->con, $_POST["firstname"])."',
							image_url = '".mysqli_real_escape_string($obj->con, $_POST["image_url"])."',
							access_token = '".mysqli_real_escape_string($obj->con, $_POST["access_token"])."',
							updated_at = 'NOW()'
							WHERE email_id = '".$email."'";
		$status = $obj->update_delete($sql_query);
		if($status){
			$returnArray = array(
				'status' => 'success',
				'firstname' => $_POST["firstname"],
				'email' => $email,
				'image_url' => $_POST["image_url"],
				'access_token' => $_POST['access_token']
				);
		}else{
			$returnArray = array(
				'status' => "error",
				'message' => 'unable to update record',
				'access_token' => $_POST['access_token']
				);
		}
	}else
	{
		$sql_query = "insert into users 
						('first_name','email_id','image_url','role_id','status','access_token','created_at','updated_at')
						VALUES('".mysqli_real_escape_string($obj->con, $_POST["firstname"])."',
						'".$email."','".mysqli_real_escape_string($obj->con, $_POST["image_url"])."','2','1',
						'".mysqli_real_escape_string($obj->con, $_POST["access_token"])."','NOW()','NOW()'
						)";
		$insert_id = $obj->insert_with_id($obj->query);
		if($insert_id){
			$returnArray = array(
				'id' => $insert_id,
				'status' => 'success',
				'firstname' => $_POST["firstname"],
				'email' => $email,
				'image_url' => $_POST["image_url"],
				'access_token' => $_POST['access_token']
				)
		}else{
			$returnArray = array(
				'status' => "error",
				'message' => 'unable to insert record',
				'access_token' => $_POST['access_token']
				);
		}
	}
}else{
	$returnArray = array(
				'status' => "error",
				'message' => 'no access token given',
				'access_token' => $_POST['access_token']
				);
}
echo json_encode($returnArray);
exit;
?>