<?php 
session_start();
  $conn = mysqli_connect("localhost", "root","", "librarymanage");
  if(strlen($_SESSION['login'])==0)
  {
    header("location: login.php");
  }
  else
  {
?>

<style>
.container1 {
    position: absolute;
    width: calc(100% - 200px);
    left: 200px;
    top: 95px;
}

.custom {
    display: flow-root;
    left: 50%;
    width: fit-content;
    height: fit-content;
}

.modal-body1 {
    position: relative;
    height: fit-content;
    padding: 15px;
    overflow-y: auto;
}
.s-upper {
    color: white;
    background-color: #2777bb;
    margin-top: 0em;
    margin-left: 0em;
    font-size: 1vh;
    padding-top: 2em;
    padding-left: 2em;
    word-spacing: 5px;
  }
  .contain{
      padding: 0 10px;
  }
  .u-text {
    margin-left: 40%;
  }
</style>
<!DOCTYPE html>
<html lang="en">

  
	  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 
<head></head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
	<link rel="stylesheet" type="text/css" href="css/nav.css">
</head>

<body>

    <?php include("sidenav.php") ?>
    <div class="container1">
    <?php include("admin_nav.php") ?>
	<div class="container-fluid">
	<div class="col-lg-12" style="width:100%;">
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
						<b>List of Books</b>
						<span class="float:right"><a class="btn btn-primary float-right btn-sm"  href="admin_add_book.php" style="padding: 5px 5px; margin-bottom: 8px;margin-left: 5px;" ><i class="fa fa-plus">Add Book</i> 
				</a></span>
					</div>
					<div class="card-body" style="overflow-x: auto">
			<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
				<thead>
					<tr>
						<th class="text-center si">Id</th>
						<th class="text-center si">Image</th>
						<th class="text-center si ">Name</th>
						<th class="text-center si">Category</th>
						<th class="text-center si">AuthorName</th>
                        <th class="text-center si">Isbn</th>
                        <th class="text-center si">Price</th>
						<th class="text-center si">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$users = $conn->query("select * from books order by b_id ASC");
						while($row= $users->fetch_assoc()):
					?>
					<tr class="text-center">
						<td class="ri">
							<?php echo $row['b_id']?>
						</td class="ri">
						<td class="ri">
						<a href="#<?php  echo $row['b_id'];?>" data-bs-toggle="modal">
                            <?php if($row['cover'] != ""): ?>
                            <img src="<?php echo $row['cover']; ?>" width="100px" height="100px"
                                style="border:1px solid #333333;">
                            <?php else: ?>
                            <img src="img/avatar.png" width="100px" height="100px" style="border:1px solid #333333;">
                            <?php endif; ?>
                        </a>
							
						</td>
						<td class="ri">
							<?php echo ucwords($row['name']) ?>
						</td>
						
						<td class="ri">
                        <?php $cid = $row['categoryid'];
                            $cat = $conn->query("SELECT * FROM category where c_id= '$cid' ");
                            while($row1= $cat->fetch_assoc()):
                            echo $row1['name'] ?>
                        <?php endwhile; ?>
						</td>
						<td class="ri">
							<?php echo $row['author'] ?>
						</td>
						<td class="ri">
							<?php echo $row['isbn'] ?>
						</td>
                        <td class="ri">
							<?php echo $row['price'] ?>
						</td>
						<td class="ri">
							<a class="btn btn-info " href="managebook.php?bid=<?php echo $row['b_id'];?>" > Edit </a>
							<button class="btn btn-sm btn-danger delete_book" type="button" data-bs-toggle="modal" data-bs-target="#deletemodal" data-id="<?php echo $row['b_id'] ?>">Delete</button>
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
<?php 
    $result = $conn->query("SELECT * FROM authors");
    $result->fetch_all(MYSQLI_ASSOC);
?>

<script>
    $(document).ready(function () {
		$('#example').DataTable();
		$('.dataTables_length').addClass('bs-select');
        $('.edit_book').click(function(e)
		{
			e.preventDefault();
			var bid = $(this).attr("data-id");
			$.ajax({
				type: "POST",
				url: "datahandle.php",
				data:{
					'checking_editbook': true,
					'bid':bid,
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
</script>
<?php } ?>