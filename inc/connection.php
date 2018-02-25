<?php 
class connection
{
	var $con,$db,$query,$result;
	function connect()
	{
		$this->con=mysqli_connect("localhost","root","");
		$this->db=mysqli_select_db($this->con,"kishan");
	}
	
	function insert_update_delete($str)
	{
		$this->query=$str;
		if(mysqli_query($this->con,$this->query)){
			return true;
		}else{
			return false;
		}
	}
	
	function select($str)
	{
		$this->query=$str;
		$this->result=mysqli_query($this->con,$this->query);
	}
}
?>
