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
$today = date('Y-m-d');

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
	<div class="col-lg-12" style="width:100%;">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
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
				<div class="card">
					<div class="card-header">
						<b>List of Issued Books</b>
						
				</a></span>
					</div>
					<div class="card-body" style="overflow-x: auto">
			<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
				<thead>
					<tr>
						<th class="text-center si">I_Id</th>
                        <th class="text-center si">Student ID</th>
						<th class="text-center si">Student Name</th>
                        <th class="text-center si">Book Name</th>
						<th class="text-center si ">ISBN</th>
						<th class="text-center si">Issued Date</th>
						<th class="text-center si">Return Date</th>
						<th class="text-center si">Returned Date</th>
						<th class="text-center si">Fine</th>
						<th class="text-center si">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$users = $conn->query("SELECT issuedbook.i_id,issuedbook.bookid,issuedbook.issueDate,issuedbook.returndate,issuedbook.returneddate,issuedbook.returnstatus,issuedbook.fine,students.Studentid,students.Name as sname,students.photo,books.name,books.cover,books.categoryid,books.author,books.isbn,books.price FROM issuedbook JOIN students ON issuedbook.Studentid = students.Studentid JOIN books ON books.b_id=issuedbook.bookid JOIN category ON books.categoryid=category.c_id order by issuedbook.i_id");
						while($row= $users->fetch_assoc()):
					?>
					<tr class="text-center">
						<td class="ri">
							<?php echo $row['i_id']?>
						</td class="ri">
                        <td class="ri">
						<?php echo ucwords($row['Studentid']) ?>
						</td>
						<td class="ri">
						<?php echo ucwords($row['sname']) ?>
						</td>
						<td class="ri">
							<?php echo ucwords($row['name']) ?>
						</td>
						
						<td class="ri">
							<?php echo $row['isbn'] ?>
						</td>
						<td class="ri">
							<?php echo date('d-m-Y', strtotime($row['issueDate'])); ?>
						</td>
                        <td class="ri">
							<?php echo date('d-m-Y', strtotime($row['returndate'])); ?>
						</td>
                        <td class="ri">
                            <?php $returned=date('d-m-Y', strtotime($row['returneddate'])); ?>
							<?php echo empty($returned =='01-01-1970') ? $returned : 'Not Returned'; ?>
						</td>
						<td class="ri">
							<?php echo $row['fine']; ?>
						</td>
						<td class="ri">
							<button class="btn btn-sm btn-info edit_ibook" data-id="<?php echo $row['i_id'] ?>" type="button" <?php if($row['returnstatus'] == 0 ){ echo "disabled='true'";}?>"> Edit </button>
							<button class="btn btn-sm btn-danger delete_ibook" type="button" data-bs-toggle="modal" data-bs-target="#deletemodal" data-id="<?php echo $row['i_id'] ?>">Delete</button>
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

<!--########################################### Manage account #################################################################-->
<div class="modal fade" id="edit-ibook" tabindex="-1" role="dialog" aria-labelledby="viewuserLabel" aria-hidden="true">
	<div class="modal-dialog" role="document" style="margin: 5% 32%;">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title" id="exampleModalLabel">Manage Detail</h4>
		  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
		  <form action="datahandle.php" method="POST" id="edit_ibook">
		  	  <input type='hidden' name='edit_iid' id='edit_iid' >
                <input type='hidden' name='edit_return' id='edit_return' value="">	
				<div class="form-group">
				<label for="" class="control-label">Student ID</label>
				<input type="text" class="form-control" id="editsid" name="editsid" readonly>
			</div>		
			  <div class="form-group">
				  <label for="" class="control-label">Student Name</label>
				  <input type="text" class="form-control" id="editsname" name="editsname" readonly>
			  </div>
              <div class="form-group">
				  <label for="" class="control-label">Book Name</label>
				  <input type="text" class="form-control" id="editbname" name="editbname" readonly>
			  </div>
              <div class="form-group">
				  <label for="" class="control-label">Book Author</label>
				  <input type="text" class="form-control" id="editauthor" name="editauthor" readonly>
			  </div>
			  <div class="form-group">
				<label for="mobile number">ISBN</label>
				<input type="text" name="editisbn" id="editisbn" class="form-control" readonly >
			</div>
			  <div class="form-group">
				  <label for="" class="control-label">Returned Date</label>
				  <input type="date" class="form-control" name="editrdate" value="<?php echo $today;?>" id="editrdate">
			  </div>	
			  	
			  <div class="form-group">
              <button class="btn btn-sm btn-info edit_check" type="button" onclick="checkfine();" style="float: right;"> Check </button>
			  <label for="">Total Fine(in Rs.)</label>
				  <input type="text" name="editfine" id="editfine" class="form-control" readonly>
			  </div>		
			  <div class="modal-footer">
				  <button type="submit" class="btn btn-primary" name="editibooksubmit">Save</button>
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
        <h5 class="modal-title" id="exampleModalLabel">Delete Issue Record</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  	<form action="datahandle.php" method="POST">
			<input type="hidden" name="del_id" id="del_id" value="">
			<h4> Do you want to Delete this Record </h4>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" name="delete_issued">Yes</button>
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
		$('.edit_ibook').click(function(e)
		{
			e.preventDefault();
			var iid = $(this).attr("data-id");
            var $rdate = "<?php echo $today; ?>";
			$.ajax({
				type: "POST",
				url: "datahandle.php",
				data:{
					'checking_iidedit': true,
					'iid':iid,
				},
				success: function (response) {
                  console.log(response);
					$.each(response,function(key,value)
					{
                        console.log(response);
						$('#edit_iid').attr('value',value['i_id']);
						$('#editsid').attr('value',value['Studentid']);
						$('#editsname').val(value['sname']);
                        $('#editbname').val(value['name']);
                        $('#editauthor').val(value['author']);
                        $('#edit_return').val(value['returndate']);
                        $('#editisbn').val(value['isbn']);
						$('#edit-ibook').modal('show');
					});
				}
			});
		});
		$(".delete_ibook").click(function(e){
			e.preventDefault;
			var iid = $(this).attr("data-id");
			$("#del_id").val(iid);
		});
	});
    function checkfine()
    {
        var returned=$('#editrdate').val();
        var retun=$('#edit_return').val();
        var diff = new Date(returned).getTime() - new Date(retun).getTime();   
        var daydiff = Math.round(diff / (1000 * 60 * 60 * 24));   
        if(daydiff<=0){
            $('#editfine').val('0.0');
        }
        else{
            var fine = Math.round(daydiff*2.0);
            $('#editfine').val(fine);
        }
    }

</script>
<?php } ?>