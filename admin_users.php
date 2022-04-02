<?php 
session_start();
$conn=new mysqli("localhost","root","","librarymanage");
if(mysqli_connect_error())
{
	die('Connect Error('. mysqli_connect_errno().')'.mysqli_connect_error());
}
if(strlen($_SESSION['login'])==0)
{
  header("location: login.php");
}
else
{

?>
<style>
	.text-center{
		text-align: center;
	}
	.si{
		font-size: 1.2rem;
		font-weight: bold;
		height: 2rem;
	}
	.ri{
		padding: 8px 0;
		font-size: 17px;
	}
	.form-div { margin-top: 100px; border: 1px solid #e0e0e0; }
	#profileDisplay,#profileDis{ display: block; height: 210px; width: 60%; margin: 0px auto; border-radius: 50%; }
	.img-placeholder {
  width: 60%;
  color: white;
  height: 100%;
  background: black;
  opacity: .7;
  height: 210px;
  border-radius: 50%;
  z-index: 2;
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  display: none;
	}
	.img-placeholder h4 {
  margin-top: 40%;
  color: white;
	}
	.img-div:hover .img-placeholder {
  display: block;
  cursor: pointer;
	}

	.container1{
	
    position: relative;
    width: calc(100% - 200px);
    left: 200px;
    top: 0;

	}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/nav.css">
	<link rel="stylesheet" type="text/css" href="css/navbar.css">
	<link href="css/manageuser.css" rel="stylesheet" type="text/css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" type="text/javascript"></script>

</head>
<body>
<?php include("sidenav.php") ?>
	 <div class="container1">
	<?php include("admin_nav.php") ?>
	<div class="container-fluid">
	<div class="col-lg-12"style="width:100%;">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
			</div>
		</div>
		<div class="row">
		<?php if($_SESSION['status']!="")
			{?>
		<div class="col-md-6">
		<div class="alert alert-danger" >
		<strong>Status :</strong> 
		<?php echo htmlentities($_SESSION['status']);?>
		<?php echo htmlentities($_SESSION['status']="");?>
		</div>
		</div>
		<?php } ?>
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>List of Users</b>
						<span class="float:right"><a class="btn btn-primary float-right btn-sm" data-bs-target="#new--user" data-bs-toggle="modal">
					<i class="fa fa-plus">Add User</i> 
				</a></span>
					</div>
					<div class="card-body" style="overflow-x: auto">
			<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
				<thead>
					<tr>
						<th class="text-center si">S_Id</th>
						<th class="text-center si">Photo</th>
						<th class="text-center si ">Name</th>
						<th class="text-center si">Email</th>
						<th class="text-center si">Mobile No.</th>
						<th class="text-center si">Status</th>
						<th class="text-center si">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$users = $conn->query("SELECT * FROM students order by Studentid");
						while($row= $users->fetch_assoc()):
					?>
					<tr class="text-center">
						<td class="ri">
							<?php echo $row['Studentid']?>
						</td class="ri">
						<td class="ri">
						<img src="<?php echo ucwords($row['photo']) ?>" width="100px" height="100px"style="border:1px solid #333333;">
							
						</td>
						<td class="ri">
							<?php echo ucwords($row['Name']) ?>
						</td>
						
						<td class="ri">
							<?php echo $row['Emailid'] ?>
						</td>
						<td class="ri">
							<?php echo $row['Mobilenumber'] ?>
						</td>
						<td class="ri">
							<?php echo $row['status'] ?>
						</td>
						<td class="ri">
							<button class="btn btn-sm btn-info edit_user" data-id="<?php echo $row['Studentid'] ?>" type="button"> Edit </button>
							<button class="btn btn-sm btn-danger delete_user" type="button" data-bs-toggle="modal" data-bs-target="#deletemodal" data-id="<?php echo $row['Studentid'] ?>">Delete</button>
						</td>
					</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
					</div>
				</div>
			</div>
		</div>
	</div>	
</div>
	</div>
<!-- ########################################### New Account ##########################################################################################-->

<div class="modal fade" id="new--user" tabindex="-1" role="dialog" aria-labelledby="viewuserLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="margin: 5% 32%;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">New User</h4>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form action="datahandle.php" method="POST" id="new-user" enctype="multipart/form-data">
			<div id="err"></div>	
			<div class="form-group text-center" style="position: relative;" >
				<span class="img-div">
				<div class="text-center img-placeholder"  onClick="triggerClick()">
					<h4>Update image</h4>
				</div>
				<img src="img/avatar.jpeg" onClick="triggerClick()" id="profileDisplay">
				
				</span>
				<input type="file" name="profileImage" onChange="displayImage(this)" id="profileImage" class="form-control" style="display: none;">
				<label>Profile Image</label>
          	</div>	

			  <div class="form-group">
				<label for="" class="control-label">Student ID</label>
				<input type="text" class="form-control" id="newsid" name="newsid">
			</div>

			<div class="form-group">
				<label for="" class="control-label">Name</label>
				<input type="text" class="form-control" id="newusername" name="newusername">
			</div>
			<div class="form-group">
				<label for="" class="control-label">Email</label>
				<input type="email" class="form-control" name="newemail" >
			</div>			
			<div class="form-group">
				<label for="mobile number">Mobile No.</label>
				<input type="text" name="newmobile" id="newmobile" class="form-control" autocomplete="off" required >
			</div>
			<div class="form-group">
			<label for="password">Password</label>
				<input type="password" name="newpassword" id="newpassword" class="form-control" autocomplete="off" required>
			</div>		
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" name='newusersubmit'>Save</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
			</div>
		</form>
      </div>
    </div>
  </div>
</div>

<!--########################################### Manage account #################################################################-->
<div class="modal fade" id="edit__user" tabindex="-1" role="dialog" aria-labelledby="viewuserLabel" aria-hidden="true">
	<div class="modal-dialog" role="document" style="margin: 5% 32%;">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title" id="exampleModalLabel">Manage Detail</h4>
		  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
		  <form action="datahandle.php" method="POST" id="edit_user" enctype="multipart/form-data">
		  	  <input type='hidden' name='edit_sid' id='edit_sid' value="">
			  <div class="form-group text-center" style="position: relative;" >
				  <span class="img-div">
				  <div class="text-center img-placeholder"  onClick="triggerClck()">
					  <h4>Update image</h4>
				  </div>
				  <img src="" alt="Not Available" onClick="triggerClck()" id="profiledis">
				  </span>
				  <input type="hidden" id="fakepic" name="fakepic" value="">	
				  <input type="file" name="profileImg" onChange="displayImg(this)" id="profileImg" value="" class="form-control" style="display: none;">
				  <label>Profile Image</label>
				</div>			
				<div class="form-group">
				<label for="" class="control-label">Student ID</label>
				<input type="text" class="form-control" id="editsid" name="editsid" readonly>
			</div>		
			  <div class="form-group">
				  <label for="" class="control-label">Name</label>
				  <input type="text" class="form-control" id="editname" name="editname">
			  </div>
			  <div class="form-group">
				<label for="mobile number">Mobile No.</label>
				<input type="text" name="editmobile" id="editmobile" class="form-control" autocomplete="off" required >
			</div>
			  <div class="form-group">
				  <label for="" class="control-label">Email</label>
				  <input type="email" class="form-control" name="editemail" id="editemail">
			  </div>		
			  <div class="form-group">
			  <label for="password">Password</label>
				  <input type="text" name="editpassword" id="editpassword" class="form-control"  autocomplete="off" required>
			  </div>		
			  <div class="modal-footer">
				  <button type="submit" class="btn btn-primary" name="editusersubmit">Save</button>
				  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
			  </div>
		  </form>
		</div>
	  </div>
	</div>
  </div>


<!--########################################### Delete account #################################################################-->

<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="deletemodalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  	<form action="datahandle.php" method="POST">
			<input type="hidden" name="del_id" id="del_id" value="">
			<h4> Do you want to Delete this User </h4>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" name="delete_user">Yes</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
			</div>
	  	</form>
      </div>
    </div>
  </div>
</div>

</body>
</html>

<script>
	$(document).ready(function () {
		$('#example').DataTable();
		$('.dataTables_length').addClass('bs-select');
		$('.edit_user').click(function(e)
		{
			e.preventDefault();
			var student = $(this).attr("data-id");
			$.ajax({
				type: "POST",
				url: "datahandle.php",
				data:{
					'checking_editbtn': true,
					'sid':student,
				},
				success: function (response) {
					$.each(response,function(key,value)
					{
						console.log(response);
						$('#edit_sid').attr('value',value['Studentid']);
						$('#editsid').attr('value',value['Studentid']);
						$('#editname').val(value['Name']);
						$('#editemail').val(value['Emailid']);
						$('#editmobile').val(value['Mobilenumber']);
						$('#editpassword').val(value['Password']);
						$('#profiledis').attr('src',value['photo']);
						$('#fakepic').attr('value',value['photo']);
						$('#edit__user').modal('show');
					});
				}
			});
		});
		$(".delete_user").click(function(e){
			e.preventDefault;
			var sid = $(this).attr("data-id");
			$("#del_id").val(sid);
		});
	});
	//////////////////////////////////////////////
	function triggerClick(e) {
  		document.querySelector('#profileImage').click();
	};

	function displayImage(e) {
  		if (e.files[0]) {
    		var reader = new FileReader();
    		reader.onload = function(e){
      			document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
    		}
    	reader.readAsDataURL(e.files[0]);
  		}
	};
  ///////////////////////////////////////////////////////////
	function triggerClck(e) {
  		document.querySelector('#profileImg').click();
	};

	function displayImg(e) {
  		if (e.files[0]) {
    		var reader = new FileReader();
    		reader.onload = function(e){
      			document.querySelector('#profileDis').setAttribute('src', e.target.result);
    		}
    	reader.readAsDataURL(e.files[0]);
  		}
	};

</script>
<?php } ?>