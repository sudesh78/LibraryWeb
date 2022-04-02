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
						<span class="float:right"><a class="btn btn-primary float-right btn-sm" data-bs-target="#new--author" data-bs-toggle="modal">
					<i class="fa fa-plus">Add Author</i> 
				</a></span>
					</div>
					<div class="card-body" style="overflow-x: auto">
			<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
				<thead>
					<tr>
						<th class="text-center si">S_Id</th>
						<th class="text-center si ">Name</th>
						<th class="text-center si">Status</th>
						<th class="text-center si">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$users = $conn->query("SELECT * FROM authors");
						$i=0;
                        while($row= $users->fetch_assoc()):
                            $i++;
					?>
					<tr class="text-center">
						<td class="ri">
							<?php echo $i ?>
						</td class="ri">
						<td class="ri">
							<?php echo ucwords($row['name']) ?>
						</td>
                        <td class="ri"><?php 
									
                                    $status=$row["status"];
                                    if($status==0)
                                    {
                                        echo'<a data-id='.$row["a_id"].' class="btn btn-sm btn-danger actauthor">Activate Now</a>';
                                    }
                                    else
                                    {
                                        echo'<a data-id='.$row["a_id"].' class="btn btn-sm btn-success deactauthor">Deactivate Now</a>';
                                    }
                                
                                ?></td>
						<td class="ri">
							<button class="btn btn-sm btn-danger delete_author" type="button" data-bs-toggle="modal" data-bs-target="#deletemodal" data-id="<?php echo $row['a_id'] ?>">Delete</button>
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

<div class="modal fade" id="new--author" tabindex="-1" role="dialog" aria-labelledby="viewuserLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="margin: 5% 32%;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">New Author</h4>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form action="datahandle.php" method="POST" id="new-author">
            <div class="form-group">
            <label>Author Name</label>
            <input class="form-control" type="text" name="author" autocomplete="off" required />
            </div>
            <div class="form-group">
            <label>Status</label>
            <div class="radio">
            <label>
            <input type="radio" name="status" id="status" value="1" checked="checked">Active
            </label>
            </div>
            <div class="radio">
            <label>
            <input type="radio" name="status" id="status" value="0">Inactive
            </label>
            </div>

            </div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" name='newauthorsubmit'>Save</button>
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
        <h5 class="modal-title" id="exampleModalLabel">Delete Author</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  	<form action="datahandle.php" method="POST">
			<input type="hidden" name="del_id" id="del_id" value="">
			<h4> Do you want to Delete this Author </h4>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" name="delete_author">Yes</button>
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
		$(".delete_author").click(function(e){
			e.preventDefault;
			var aid = $(this).attr("data-id");
			$("#del_id").val(aid);
		});
        $(".actauthor").click(function(e){
			var aid = $(this).attr("data-id");
            $.ajax({  
                url:"datahandle.php",  
                method:"POST",  
                data:{'aid':aid,'activate':true},    
                success:function(data){ 
                    setInterval('location.reload()', 10);  
                }  
            });  
		});
        $(".deactauthor").click(function(e){
			var aid = $(this).attr("data-id");
            $.ajax({  
                url:"datahandle.php",  
                method:"POST",  
                data:{'aid':aid,'deactivate':true},    
                success:function(data){  
                    setInterval('location.reload()', 10);  
                }  
            });  
		});

	});

</script>
<?php } ?>