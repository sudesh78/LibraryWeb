<?php 
session_start();
$con=new mysqli("localhost","root","","librarymanage");
if(mysqli_connect_error())
{
    die('Connect Error('. mysqli_connect_errno().')'.mysqli_connect_error());
}

 if(isset($_GET["id"])&&!empty($_GET["id"]))
 {
	 $sql="UPDATE category SET status='1' WHERE c_id=".$_GET["id"];
	 $con->query($sql);
	 $_SESSION['status'] = "Updated Successfully";
		header("Location: admin_addcat.php");
 }
 else
 {
	$_SESSION['status'] = "Updated Successfully";
		header("Location: admin_addcat.php");
 }

?>