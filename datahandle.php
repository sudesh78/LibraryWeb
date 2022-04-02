<?php 
session_start();
  	$conn = mysqli_connect("localhost", "root","", "librarymanage");

	if(isset($_GET['bid']))
	{
		$bid = $_GET['bid'];
		$query = "Delete from books where b_id=$bid";
		$result = mysqli_query($conn,$query);
		if($result)
		{
			echo "Success";
			header("Location: admin_view_book.php");

		}
		else{
			echo "Fail";
		}
	}
/////////////////////Book Add //////////////////
	if(isset($_POST['add']))
	{
			$targetDir = "uploads/";
			if(!empty($_FILES['image']['name']))
			$avatar_path = $conn->real_escape_string('uploads/'.$_FILES['image']['name']);
			else
			$avatar_path = "img/avatar.jpeg";
			$bookname=$_POST['bookname'];
			$category=$_POST['category'];
			$author=$_POST['author'];
			$isbn=$_POST['isbn'];
			$price=$_POST['price'];
		
			if(preg_match("!image!",$_FILES['image']['type']))
			{
				if(move_uploaded_file($_FILES['image']['tmp_name'],$avatar_path))
				{
					$sql="
						INSERT INTO books(name,categoryid,author,cover,isbn,price)
						VALUES 
						('$bookname','$category' , '$author', '$avatar_path','$isbn','$price');
						";
						
					if($conn->query($sql)==true)
					{
						$_SESSION['status']="Successfully Saved";
						header("Location: admin_view_book.php");
					}
					else{
						$_SESSION['status']="Book could not be added to the database";
						header("Location: admin_view_book.php");
					}
				}
				else{
					$_SESSION['status']="File upload failed!";
					header("Location: admin_view_book.php");
				}
			}
			else{
				$_SESSION['status']="Please only upload GIF, JPG , or PNG images";
				header("Location: admin_view_book.php");
			}
	}
////////////////////////////////////////////////////

//////////////////update book////////////////////////////
	if(isset($_POST["updatebook"]))
	{
		$bid = $_POST['bid'];
		$bookname = $_POST['bookname'];
		$category = $_POST['category'];
		$author = $_POST['eauthor'];
		$isbn = $_POST['isbn'];
		$price = $_POST['price'];
		$new_image = $_FILES['profileImg']['name'];
		$old_image = $_POST['fakepic'];
		
			if($new_image != '')
			{
				$update_filename = $conn->real_escape_string('uploads/'.$_FILES['profileImg']['name']);
				echo "$update_filename";
			}
			else{
				$update_filename = $conn->real_escape_string($_POST['fakepic']);
				echo "$update_filename";
			}

		$query = "Update books set name='$bookname',categoryid=$category, author='$author',
				isbn=$isbn,price=$price,cover='$update_filename' where b_id=$bid";
		$result = mysqli_query($conn,$query);
		if($result){
			if($_FILES['profileImg']['name']!='')
			{
				move_uploaded_file($_FILES["profileImg"]["tmp_name"],"uploads/".$_FILES["profileImg"]["name"]);
				unlink($old_image);
			}
			$_SESSION['status'] = "Updated Successfully";
			header("Location: admin_view_book.php");
		}
		else{
			$_SESSION['status'] = "Updated fail";
			header("Location: managebook.php?id=$bid");
		}
	}

	if(isset($_POST["newusersubmit"]))
	{
		$sid = $_POST['newsid'];
		$name = $_POST['newusername'];
		$email = $_POST['newemail'];
		$mobile = $_POST['newmobile'];
		$password = $_POST['newpassword'];
		$new_image = $_FILES['profileImage']['name'];
		rename("$new_image", 'new_location/image1.jpg');

		$update_filename = $conn->real_escape_string('uploads/'.$_FILES['profileImage']['name']);

		$query = "Insert into students(Studentid,Name,emailid,mobilenumber,password,photo,status) 
				values($sid,'$name','$email','$mobile','$password','$update_filename',1);";
		$result = mysqli_query($conn,$query);
		echo $sid,$name,$email,$mobile,$password,$update_filename;
		if($result){
			if($_FILES["profileImage"]['name']!='')
			{
				move_uploaded_file($_FILES["profileImage"]["tmp_name"],"uploads/".$_FILES["profileImage"]["name"]);
				unlink($old_image);
			}
			$_SESSION['status'] = "Updated Successfully";
			header("Location: admin_users.php");
		}
		else{
			$_SESSION['status']="Update Unsucessful";
			header("Location: admin_view_book.php");

		}	
	}

	if(isset($_POST["checking_editbtn"]))
	{
		$result_array = [];
		$sid = $_POST['sid'];
		$query = "SELECT * FROM students where studentid=$sid ";
		$query_run = mysqli_query($conn,$query);

		if(mysqli_num_rows($query_run) > 0)
		{
			foreach($query_run as $row)
			{
				array_push($result_array,$row);
				header('Content-type: application/json');
				echo json_encode($result_array);
			}
		}
		else
		{
			echo $return = "<h5>No Record Found</h5>";
		}
	}

	if(isset($_POST["editusersubmit"]))
	{
		$sid = $_POST['editsid'];
		$name = $_POST['editname'];
		$email = $_POST['editemail'];
		$mobile = $_POST['editmobile'];
		$password = $_POST['editpassword'];
		$new_image = $_FILES['profileImg']['name'];
		$old_image = $_POST['fakepic'];
    
        if($new_image != '')
        {
            $update_filename = $conn->real_escape_string('uploads/'.$_FILES['profileImg']['name']);
        }
        else{
            $update_filename = $conn->real_escape_string($_POST['fakepic']);
        }

		$query = "Update students set
				  name='$name',emailid='$email',password='$password',
				  mobilenumber='$mobile',photo='$update_filename' where Studentid=$sid;";
		$result = mysqli_query($conn,$query);

		if($result){
			if($_FILES["profileImg"]['name']!='')
			{
				move_uploaded_file($_FILES["profileImg"]["tmp_name"],"uploads/".$_FILES["profileImg"]["name"]);
				unlink($old_image);
			}
			$_SESSION['status'] = "Updated Successfully";
			header("Location: admin_users.php");

		}
		else{
			echo "Update Unsuccessful";
			header("Location: admin_users.php");
		}	
	}

	if(isset($_POST["delete_user"]))
	{
		$sid = $_POST['del_id'];
		$query = "Select photo from students where Studentid=$sid";
		$query1 = "Delete from students where Studentid=$sid";
		$result = mysqli_query($conn,$query);
		if(mysqli_num_rows($result) > 0)
		{
			foreach($result as $row)
			{
				$photo = $row['photo'];
			}
			$result1 = mysqli_query($conn,$query1);
			if($result1)
			{
				$_SESSION['status'] = "Update Successfull";
				unlink($photo);
				header("Location: admin_users.php");
			}
			else
			{
				$_SESSION['status'] = "Update UnSuccessful";
				header("Location: admin_users.php");
			}
		}
		else{
			$_SESSION['status'] = "Update UnSuccessful ";
			header("Location: admin_users.php");
		}

	}
  //////////////////Member Section ///////////////////////////
  if(isset($_POST["newmembersubmit"]))
  {
	  $mid = $_POST['newmid'];
	  $name = $_POST['newmembername'];
	  $email = $_POST['newemail'];
	  $mobile = $_POST['newmobile'];
	  $password = $_POST['newpassword'];
	  $new_image = $_FILES['profileImage']['name'];

	  $update_filename = $conn->real_escape_string('uploads/'.$_FILES['profileImage']['name']);

	  $query = "Insert into admin(Member_id,Name,emailid,mobileno,password,photo) 
			  values($mid,'$name','$email','$mobile','$password','$update_filename');";
	  $result = mysqli_query($conn,$query);
	  if($result){
		  if($_FILES["profileImage"]['name']!='')
		  {
			  move_uploaded_file($_FILES["profileImage"]["tmp_name"],"uploads/".$_FILES["profileImage"]["name"]);
			  unlink($old_image);
		  }
		  $_SESSION['status'] = "Updated Successfully";
		  header("Location: adminsec.php");
	  }
	  else{
			$_SESSION['status']="Update Unsuccessful";
			header("Location: adminsec.php");;

	  }	
  }

  if(isset($_POST["checking_memberedit"]))
  {
		$result_array = [];
		$mid = $_POST['m_id'];
		$query = "SELECT * FROM admin where Member_id=$mid ";
		$query_run = mysqli_query($conn,$query);

		if(mysqli_num_rows($query_run) > 0)
		{
			foreach($query_run as $row)
			{
				array_push($result_array,$row);
				header('Content-type: application/json');
				echo json_encode($result_array);
			}
		}
		else
		{
			echo $return = "<h5>No Record Found</h5>";
		}
  }

  if(isset($_POST["editmembersubmit"]))
	{
		$mid = $_POST['editmid'];
		$name = $_POST['editname'];
		$email = $_POST['editemail'];
		$mobile = $_POST['editmobile'];
		$password = $_POST['editpassword'];
		$new_image = $_FILES['profileImg']['name'];
		$old_image = $_POST['fakepic'];
    
        if($new_image != '')
        {
            $update_filename = $conn->real_escape_string('uploads/'.$_FILES['profileImg']['name']);
        }
        else{
            $update_filename = $conn->real_escape_string($_POST['fakepic']);
        }

		$query = "Update admin set
				  name='$name',emailid='$email',password='$password',
				  mobileno='$mobile',photo='$update_filename' where Member_id=$mid;";
		$result = mysqli_query($conn,$query);

		if($result){
			if($_FILES["profileImg"]['name']!='')
			{
				move_uploaded_file($_FILES["profileImg"]["tmp_name"],"uploads/".$_FILES["profileImg"]["name"]);
				unlink($old_image);
			}
			$_SESSION['status'] = "Updated Successfully";
			header("Location: adminsec.php");
		}
		else{
			$_SESSION['status']="Update Unsuccessful";
			header("Location: adminsec.php");
		}	
	}

  if(isset($_POST["delete_member"]))
  {
		$mid = $_POST['del_mid'];
		$query = "Select photo from admin where Member_id=$mid";
		$query1 = "Delete from admin where Member_id=$mid;";
		$result = mysqli_query($conn,$query);
		if(mysqli_num_rows($result) > 0)
		{
			foreach($result as $row)
			{
				$photo = $row['photo'];
			}
			$result1 = mysqli_query($conn,$query1);
			if($result1)
			{
				$_SESSION['status'] = "Update Successfull";
				unlink($photo);
				header("Location: adminsec.php");
			}
			else
			{
				$_SESSION['status'] = "Update UnSuccessful";
				header("Location: adminsec.php");
			}
		}
		else{
			$_SESSION['status'] = "Update UnSuccessful ";
			header("Location: adminsec.php");
		}

  }
///////////////////////////////////////////////////////////////////////////

if(isset($_POST["check_user"]))
{
	$result_array = [];
	$sid = $_POST['sid'];
	$query = "SELECT * FROM students where studentid=$sid ";
	$query_run = mysqli_query($conn,$query);

	if(mysqli_num_rows($query_run) > 0)
	{
		foreach($query_run as $row)
		{
			array_push($result_array,$row);
			header('Content-type: application/json');
			echo json_encode($result_array);
		}
	}
	else
	{
		echo $return = "not";
	}
}

if(isset($_POST["check_book"]))
{
	$result_array = [];
	$isbn = $_POST['isbn'];
	$query = "SELECT books.categoryid,category.name as catname,books.b_id,books.name,books.author,books.isbn,books.cover,books.price,books.quantity from books INNER JOIN category ON category.c_id=books.categoryid WHERE books.isbn=$isbn ";
	$query_run = mysqli_query($conn,$query);

	if(mysqli_num_rows($query_run) > 0)
	{
		foreach($query_run as $row)
		{
			array_push($result_array,$row);
			header('Content-type: application/json');
			echo json_encode($result_array);
		}
	}
	else
	{
		echo $return = "not";
	}
}

if(isset($_POST["s_id"]))  
{  
	 $s_id =$_POST["s_id"];
	 $b_id =$_POST["b_id"]; 
	 $b_qty =$_POST["b_qty"];
	 $s_slot =$_POST["s_slot"];  
	 $i_date =$_POST["i_date"];  
	 $r_date =$_POST["r_date"];
	 $query = "Insert into issuedbook(bookid,Studentid,issuedate,returndate) values($b_id,'$s_id','$i_date','$r_date')";
	 $query1 = "Update students set book_slot=book_slot-1 where Studentid=$s_id";
	 $query2 = "Update books set quantity=quantity-1 where b_id=$b_id";
	 $query3 = "SELECT * FROM issuedbook where bookid=$b_id && Studentid=$s_id && returnstatus=1;";
	 $query_run3 = mysqli_query($conn,$query3);

	if(mysqli_num_rows($query_run3) > 0)
	{
		print "Already Issued.";
	}
	else
	{
		$query_run = mysqli_query($conn,$query);

		if($query_run)
		{
			$query_run1 = mysqli_query($conn,$query1);
			if($query_run1)
			{
				$query_run2 = mysqli_query($conn,$query2);
				if($query_run2)
				{
					print "Successfully Issued";
				}
				else{
					$query3 = "Delete from issuedbook where bookid='$b_id' AND Studentid='$s_id'";
					$query4 = "Update students set book_slot=book_slot+1 where Studentid=$s_id";
					$query_run3 = mysqli_connect($conn,$query3);
					$query_run4 = mysqli_connect($conn,$query4);
					print "Unable to Update Book";

					}

			}
			else
			{
				$query3 = "Delete from issuedbook where bookid='$b_id' AND Studentid='$s_id'";
				$query_run3 = mysqli_connect($conn,$query3);
				print "Unable to Update Student";

			}
		}
		else
		{
			print "Unable to Update IssuedBook";
		
		}
	}

}

/////////////////////////////////////////////////////////////

if(isset($_POST['checking_iidedit']))
{
	$result_array = [];
	$iid = $_POST['iid'];
	$query = "SELECT issuedbook.i_id,issuedbook.issueDate,issuedbook.returndate,students.Studentid,students.Name as sname,books.name,books.author,books.isbn,books.price FROM issuedbook JOIN students ON issuedbook.Studentid = students.Studentid JOIN books ON books.b_id=issuedbook.bookid  where issuedbook.i_id=$iid";
	$query_run = mysqli_query($conn,$query);
	if(mysqli_num_rows($query_run) > 0)
		{
			foreach($query_run as $row)
			{
				array_push($result_array,$row);
				header('Content-type: application/json');
				$result_array = json_encode($result_array);
			}
		}
		else
		{
			echo $return = "<h5>No Record Found</h5>";
		}
		echo $result_array;
	
}

if(isset($_POST['editibooksubmit']))
{
	$i_id = $_POST['edit_iid'];
	$sid = $_POST['editsid'];
	$bisbn = $_POST['editisbn'];
	$r_date=$_POST['editrdate'];
	$fine = $_POST['editfine'];
	$query = "Update issuedbook set 
			 returneddate='$r_date',returnstatus=0,fine=$fine where i_id=$i_id";
	$query1 = "Update students set 
			book_slot=book_slot+1 where Studentid=$sid";
	$query2 = "Update books set 
			quantity=quantity+1 where isbn=$bisbn";
	$query_run= mysqli_query($conn,$query);
	if($query_run){
		$query_run1 = mysqli_query($conn,$query1);
		if($query_run1){
			$query_run2 = mysqli_query($conn,$query2);
			if($query_run2)
			{
				
				$_SESSION['status']="Successfully Returned";
				header("Location: admin_issuedbook.php");
			}
			else{
				$query3 = "Update issuedbook set returneddate=null,returnstatus=1,fine=0 where i_id=$i_id";
				$query4 = "Update books set quantity=quantity-1 where isbn=$bisbn";
				$query_run3 = mysqli_connect($conn,$query3);
				$query_run4 = mysqli_connect($conn,$query4);
				$_SESSION['status']="Unable to Update Book";
				header("Location: admin_issuedbook.php");
				}

		}
		else{
			$query3 = "Update issuedbook set 
						returneddate=null,returnstatus=1,fine=0 where i_id=$i_id";
			$query_run3 = mysqli_connect($conn,$query3);
			$_SESSION['status']="Unable to Update Student";
			header("Location: admin_issuedbook.php");
			}
		}
		else{
			$_SESSION['status']="Unable to Update IssuedBook";
			header("Location: admin_issuedbook.php");
		}
}

if(isset($_POST["delete_issued"]))
{
	  $mid = $_POST['del_id'];
	  $query = "Delete from issuedbook where i_id=$mid;";
	  $result = mysqli_query($conn,$query);
	  if($result)
	  {
		  $_SESSION['status'] = "Updated Successfully";
		  header("Location: admin_issuedbook.php");
	  }
	  else{
		$_SESSION['status'] = "Update Unsuccessful";
		header("Location: admin_issuedbook.php");

	  }
}

if(isset($_POST['register_request']))
{
	$bid = $_POST['bid'];
	$sid = $_POST['sid'];
	$query = "SELECT * FROM request where bookid=$bid && Studentid=$sid && status=0;";
	$query1 = "Insert into request(bookid,Studentid) values($bid,$sid);";
	$result = mysqli_query($conn,$query);
	
	if(mysqli_num_rows($result) > 0)
	{
		print "<p class='Error'>Already Requested.</p>";
	}
	else
	{
		$result1 = mysqli_query($conn,$query1);
		if($result){
			print "<p class='success'>Requested Successfully.</p>";
		}
		else{
			print "<p class='Error'>Unable to Register Request.</p>";
		}	
	}
}

if(isset($_POST['approvereq']))
{
	$rid = $_POST['rid'];
	$bid = $_POST['bid'];
	$isbn = $_POST['isbn'];
	$sid = $_POST['sid'];
	$udate= $_POST['udate'];
	$query = "Update request set status=1,updatedate='$udate' where r_id=$rid;";
	$query1 = "Update books set quantity=quantity-1 where isbn=$isbn";
	$query2 = "Update students set book_slot=book_slot-1 where Studentid=$sid";
	$query5 = "Select * from issuedbook where Studentid=$sid && bookid=$bid && returnstatus=1;";
	$query_run5 = mysqli_query($conn,$query5);
	if(mysqli_num_rows($query_run5) > 0)
	{
		print "Student Already Have This Book";
	}
	else
	{
		$query_run = mysqli_query($conn,$query);
		if($query_run){
			$query_run1 = mysqli_query($conn,$query1);
			if($query_run1){
				$query_run2 = mysqli_query($conn,$query2);
				if($query_run2)
				{
					print "Successfully Approved";
				}
				else{
					$query3 = "Update request set status=0,updatedate='' where r_id=$rid;";
					$query4 = "Update books set quantity=quantity-1 where isbn=$bisbn";
					$query_run3 = mysqli_connect($conn,$query3);
					$query_run4 = mysqli_connect($conn,$query4);
					print "Unable to Approve";
					}

			}
			else{
				$query3 = "Update request set status=0,updatedate='' where r_id=$rid;";
				$query_run3 = mysqli_connect($conn,$query3);
				print "Unable to Approve";
				}
			}
		else{
			print "Unable to Approve";;
		}
	}

}

if(isset($_POST['declinereq']))
{
	$rid = $_POST['rid'];
	$udate= $_POST['udate'];
	$query = "Update request set status=3,updatedate='$udate' where r_id=$rid;";
	$query_run = mysqli_query($conn,$query);

	if($query_run)
	{	
		print "Successfully Declined";
	}
	else{
		print "Unable to Decline";;
	}

}
if(isset($_POST['issue']))
{
	$rid = $_POST['rid'];
	$sid = $_POST['sid'];
	$bid = $_POST['bid'];
	$update= $_POST['update'];
	$returnd= $_POST['returnd'];
	$query = "Insert into issuedbook(bookid,Studentid,issuedate,returndate) values($bid,'$sid','$update','$returnd')";
	$query1 = "Select i_id from issuedbook where bookid = $bid && Studentid=$sid && issuedate = $update;";
	$query2 = "Delete from request where r_id=$rid;";
	$query_run = mysqli_query($conn,$query);
	if($query_run)
	{	$result = $conn->query($query1);
		while($row= $result->fetch_assoc()):
			$iid = $row['i_id'];
		endwhile;
		$query_run2 = mysqli_query($conn,$query2);
		if($query_run2)
		{
			print "Successfully Issued";
	
		}
		else
		{
			$query3 = "Delete from issuedbook where i_id=$iid;";
			print "Unable To Issue";
			
		}

	}
	else{
		print " Unable TO Issue";
	}

}
if(isset($_POST['decline']))
{
	$rid = $_POST['rid'];
	$sid = $_POST['sid'];
	$isbn = $_POST['isbn'];
	$udate= $_POST['update'];
	$query = "Update books set quantity=quantity+1 where isbn=$isbn";
	$query1= "Update students set book_slot=book_slot+1 where Studentid=$sid";
	$query2 = "Update request set status=3,updatedate='$udate' where r_id=$rid;";
	$query_run = mysqli_query($conn,$query);

	if($query_run){
		$query_run1 = mysqli_query($conn,$query1);
		if($query_run1){
			$query_run2 = mysqli_query($conn,$query2);
			if($query_run2)
			{
				
				print "Successfully Returned";

			}
			else{
				$query3 = "Update books set quantity=quantity-1 where isbn=$isbn";
				$query4 = "Update request set status=1,updatedate='$udate' where r_id=$rid;";
				$query_run3 = mysqli_connect($conn,$query3);
				$query_run4 = mysqli_connect($conn,$query4);
				print "Unable to Decline";
				}

		}
		else{
			$query3 = "Update books set quantity=quantity-1 where isbn=$isbn";
			$query_run3 = mysqli_connect($conn,$query3);
			print "Unable to Decline";

			}
		}
		else{
			print "Unable to Decline";
		
		}

}

if(isset($_POST['newcategorysubmit']))
{
	$cid = $_POST['category'];
	$st = $_POST['status'];
	$query = "Insert Into category(name,status) values('$cid',$st);";
	$result = mysqli_query($conn,$query);
	if($result)
	{
		$_SESSION['status'] = "Updated Successfully";
		header("Location: admin_addcat.php");
	}
	else{
	  $_SESSION['status'] = "Update Unsuccessful";
	  header("Location: admin_addcat.php");

	}

}

if(isset($_POST['delete_cat']))
{
	$cid = $_POST['del_id'];
	$query = "Delete from category where c_id=$cid;";
	$result = mysqli_query($conn,$query);
	if($result)
	{
		$_SESSION['status'] = "Updated Successfully";
		header("Location: admin_addcat.php");
	}
	else{
	  $_SESSION['status'] = "Update Unsuccessful";
	  header("Location: admin_addcat.php");

	}
}

if(isset($_POST['newauthorsubmit']))
{
	$aid = $_POST['author'];
	$st = $_POST['status'];
	$query = "Insert Into authors(name,status) values('$aid',$st);";
	$result = mysqli_query($conn,$query);
	if($result)
	{
		$_SESSION['status'] = "Updated Successfully";
		header("Location: admin_addauthor.php");
	}
	else{
	  $_SESSION['status'] = "Update Unsuccessful";
	  header("Location: admin_addauthor.php");

	}

}


if(isset($_POST['delete_author']))
{
	$aid = $_POST['del_id'];
	$query = "Delete from authors where a_id=$aid;";
	$result = mysqli_query($conn,$query);
	if($result)
	{
		$_SESSION['status'] = "Updated Successfully";
		header("Location: admin_addauthor.php");
	}
	else{
	  $_SESSION['status'] = "Update Unsuccessful";
	  header("Location: admin_addauthor.php");

	}
}

if($_POST['activate'])
{
	$aid = $_POST['aid'];
	$sql="UPDATE authors SET status='1' WHERE a_id=$aid";
	$result = mysqli_query($conn,$sql);
	if($result)
	{
		echo $_SESSION['status'] = "Updated Successfully";
	}
	else
	{
		echo $_SESSION['status'] = "Update Unsuccessful";
	}
	
}

if($_POST['deactivate'])
{
	$aid = $_POST['aid'];
	$sql="UPDATE authors SET status='0' WHERE a_id=$aid;";
	$result = mysqli_query($conn,$sql);
	if($result)
	{
		echo $_SESSION['status'] = "Updated Successfully";
	}
	else
	{
		echo $_SESSION['status'] = "Update Unsuccessful";
	}
	

}
?>