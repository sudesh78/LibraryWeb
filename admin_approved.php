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
$return = date('Y-m-d', strtotime('21 days'));
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
    <div class="col-md-6" style="display: contents;">
            <div class="alert alert-danger" id="msg" style="display: none;">
            <button type="button" class="close" onclick="closse();">&times;</button>
            <div id="form-status">
            
            </div>
		</div>
		</div>
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
						<th class="text-center si">Request Date</th>
						<th class="text-center si">Update Date</th>
						<th class="text-center si"> Status</th>
						<th class="text-center si">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$users = $conn->query("SELECT request.r_id,request.regdate,request.status,request.updatedate,
                        students.Studentid,students.Name as sname,books.b_id,books.name,books.cover,
                        books.author,books.isbn FROM request JOIN students ON 
                        request.Studentid = students.Studentid JOIN books 
                        ON books.b_id= request.bookid where request.status=1;");
						$i=0;
                        while($row= $users->fetch_assoc()):
                            $i++;
					?>
					<tr class="text-center">
						<td class="ri">
							<?php $bid = $row['b_id'];
                            echo $i ?>
						</td class="ri">
                        <td class="ri">
						<?php $std = $row['Studentid'];
                        echo ucwords($row['Studentid']) ?>
						</td>
						<td class="ri">
						<?php echo ucwords($row['sname']) ?>
						</td>
						<td class="ri">
							<?php echo ucwords($row['name']) ?>
						</td>
						
						<td class="ri">
                        <?php $isbn= $row['isbn'];
							 echo $row['isbn'] ?>
						</td>
						<td class="ri">
							<?php echo date('d-m-Y', strtotime($row['regdate'])); ?>
						</td>
                        <td class="ri">
                            <input type="hidden" name="curdate" id="curdate" value="<?php echo $today; ?>">
                            <input type="hidden" name="return" id="return" value="<?php echo $return; ?>">
							<?php echo date('d-m-Y', strtotime($row['updatedate'])); ?>
						</td>
                        <td class="ri">
                            <?php if($row['status'] == 1): ?>
                                <span class="badge badge-primary">Approved</span>
                            <?php elseif($row['status'] == 2): ?>
                                <span class="badge badge-success">Declined</span>	

							<?php endif; ?>
						</td>
						<td class="ri">
							<button class="btn btn-sm btn-info issue" data-id="<?php echo $row['r_id'] ?>" type="button">Issue</button>
							<button class="btn btn-sm btn-danger decline" type="button"  data-id="<?php echo $row['r_id'] ?>">Decline</button>
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

</body>
</html>

<script>
	$(document).ready(function () {

		$('#example').DataTable();
		$('.dataTables_length').addClass('bs-select');
        $('.issue').click(function(){
            var rid = $(this).attr("data-id");
            var bid = '<?php echo $bid; ?>';
            var sid = '<?php  echo $std; ?>';
            var update = $('#curdate').val();
            var returnd = $('#return').val();
            $('#error_message').html('');  
            $.ajax({  
                    url:"datahandle.php",  
                    method:"POST",  
                    data:{'rid':rid,'bid':bid,'sid':sid,'update':update,'returnd':returnd,'issue':true},  
                    success:function(data){  
                        $('#form-status').html("<p class='success'>"+data+".</p>");  
                                document.getElementById('msg').style.display="block";
                        setInterval('location.reload()', 10000);  
                    }  
                    });  
        });
            $('.decline').click(function(){
                var rid = $(this).attr("data-id");
                var sid = <?php  echo $std;?>;
                var isbn = <?php  echo $isbn;?>;
                var update = $('#curdate').val();
                $('#error_message').html('');  
                $.ajax({  
                        url:"datahandle.php",  
                        method:"POST",  
                        data:{'rid':rid,'update':update,'sid':sid,'isbn':isbn,'decline':true},    
                        success:function(data){
                            $('#form-status').html("<p class='success'>"+data+".</p>");  
                                document.getElementById('msg').style.display="block";
                            setInterval('location.reload()', 10000);  
                        }  
                        });  
            });
	});

</script>
<?php } ?>