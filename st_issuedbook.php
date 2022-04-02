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
    $sid = $_SESSION['stdid'];
    $today = date('Y-m-d');
    function dateDiff($date1, $date2)
    {
        $date1_ts = strtotime($date1);
        $date2_ts = strtotime($date2);
        $diff = $date2_ts - $date1_ts;
        return round($diff / 86400);
    }

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
    <link href="css/nav.css" rel="stylesheet" type="text/css">
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
   
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="js/bootstrap.js" type="text/javascript"></script>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" type="text/javascript"></script>
</head>
<body>
<?php include("st_sidenav.php") ?>

<div class="container1" >
<?php include("admin_nav.php") ?>
	<div class="container-fluid">
	<div class="col-lg-12" style="width: 100% ;">
		
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
						<th class="text-center si">S_No</th>
                        <th class="text-center si">Book Name</th>
                        <th class="text-center si">Cover</th>
						<th class="text-center si ">ISBN</th>
						<th class="text-center si">Issued Date</th>
						<th class="text-center si">Return Date</th>
						<th class="text-center si">Fine</th>

					</tr>
				</thead>
				<tbody>
					<?php
						$users = $conn->query("SELECT issuedbook.issueDate,
                                    issuedbook.returndate,books.name,books.cover,books.author,books.isbn FROM issuedbook JOIN students ON 
                                    issuedbook.Studentid = students.Studentid JOIN books ON books.b_id=issuedbook.bookid where students.Studentid=$sid");
						$i=0;
                        while($row= $users->fetch_assoc()):
                            $i++;
					?>
					<tr class="text-center">
						<td class="ri">
							<?php 
							echo $i;?>
						</td class="ri">
                        <td class="ri">
						<?php echo ucwords($row['name']) ?>
						</td>
                        <td class="ri"
                        ><img src='<?php echo $row['cover'] ?>' height='50px' width='50px'>
                        </td>
						<td class="ri">
						<?php echo $row['isbn'] ?>
						</td>
						<td class="ri">
							<?php 
                                $idate = date('d-m-Y', strtotime($row['issueDate']));
                                echo date('d-m-Y', strtotime($row['issueDate'])); ?>
						</td>
						
						<td class="ri">
							<?php 
                                echo date('d-m-Y', strtotime($row['returndate'])); ?>
						</td>
		
						<td class="ri">
							<?php 
                                    $dateDiff = dateDiff($today, $idate);
                                    if($dateDiff >0){
                                        echo  $dateDiff*2;
                                    }else
                                    echo  "0";
                            ?>
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
    });
</script>
<?php } ?>