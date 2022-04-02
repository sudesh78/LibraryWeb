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
	 $studentid = $_SESSION['stdid'];
?>	
<html>
<head>
<title></title>

<link href="css/nav.css" rel="stylesheet" type="text/css">
<link href="css/navbar.css" rel="stylesheet" type="text/css">
<link href="css/search.css" rel="stylesheet" type="text/css">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
 	 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>
<?php
        include('st_sidenav.php')
    ?>
<?php include('st_nav.php')?>
    <section class="hero">
	<div class="col-md-6" style="display: contents;">
			<div class="alert alert-danger" id="msg" style="display: none;">
				<div id="form-status"></div>
			</div>
		</div>
        <div class="main">
		<div class="head">
			<p>
			Search</p>
		</div>
		<div class="form fl">
			<form method="POST" action="st_search.php" style="height: 373px;">
				<p class="name">
				Search Type</p>
				<div class="form-check form-check-inline rad">
					<input class="form-check-input" type="radio" name="sea" value="BookName" checked>
					<label class="form-check-label">Book Name</label>
					</div>
					<div class="form-check form-check-inline rad">
					<input class="form-check-input" type="radio" name="sea" value="Category">
					<label class="form-check-label">Category</label>
					</div>
					<div class="form-check form-check-inline rad">
					<input class="form-check-input" type="radio" name="sea" value="Author">
					<label class="form-check-label">Author</label>
					</div>
					<div id="catsec" style="display: none;">
						<p class="name">
						Category</p>
						<select name="catselect" id="catselect"   class="form-control input-sm" style="width: 90%;">
							<option value="" >Select Category</option>
							<?php 
							$qry = $conn->query("SELECT * FROM category");
							while($row= $qry->fetch_assoc()):
							?>
							<option value="<?php echo $row['c_id'] ?>" ><?php echo $row['name'] ?></option>
							<?php endwhile; ?>
						</select>
					</div>
					
					<p class="name">
					Search </p>
					<div id="namesear" >
						<input type="text" name="searchval" id="searchval" placeholder="Book Name" class="form-control input-sm" style="width: 90%;"> 
					</div>
					<input type="text" id="authorsear" name="authorsear" placeholder="Author Name" class="form-control input-sm" style="width: 90%;display: none;"> 

					<div class="subdiv">
					<input type="submit" name="sb"  value="SUBMIT" class="sub">
					</div>
				</form>
				<div class="tail"></div>
			</div>
            </div>	

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
				<div class="card">
					<div class="card-header">
						<b>List of Books</b>
					</div>
					<div class="card-body" style="overflow-x: auto">
					<?php 
		
		if (isset($_POST['sb'])) 
		{
				$type=$_POST["sea"];
				$cat=$_POST["catselect"];
				$bname = $_POST["searchval"];
				$aname = $_POST["authorsear"];
				if($type =='BookName'){
					$sql="SELECT books.b_id,books.cover,books.name,books.isbn,category.name As cname FROM books join category on books.categoryid=category.c_id WHERE books.name LIKE '%$bname%'";
				}
				elseif($type =='Category'){
					$sql="SELECT books.b_id,books.cover,books.name,books.isbn,category.name As cname FROM books join category on books.categoryid=category.c_id WHERE books.categoryid = $cat";
				}
				elseif($type =='Author'){
					$sql="SELECT books.b_id,books.cover,books.name,books.isbn,category.name As cname FROM books join category on books.categoryid=category.c_id WHERE books.author LIKE '%$aname%'";
				}
					
					$result=$conn->query($sql);
					if($result->num_rows>0)
					{
							$i=0;
						echo "<table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered' id='example'>
									<tr class='text-primary'>	
										<th>Sno</th>
										<th>Cover</th>
										<th>Book Name</th>
										<th>Category</th>
										<th>Isbn</th>
										<th>Action</th>
									</tr>
								";
							
						while($row=$result->fetch_assoc())
						{							
								$i++;
								echo"<tr>";
								echo"<td>$i</td>";
								echo"<td><img src='{$row["cover"]}' class='don_img' height='50px' width='50px'></td>";
								echo"<td>{$row["name"]}</td>";
								echo"<td>{$row["cname"]}</td>";
								echo"<td>{$row["isbn"]}</td>";
								echo"<td><button class='btn btn-info' id='reqbook' onclick='submit();' value={$row['b_id']} >Request</button></td>";
								echo"</tr>";
						}
						
						echo "</table></div>";
						
						if($i==0)
						{
						echo "<div class='alert alert-danger'><i class='fa fa-users'></i> No Book Found </div>";
						}
					}
					else
					{
						echo "<div class='alert alert-danger'><i class='fa fa-users'></i> No Book Found</div>";
					}
			
		}	
?>
					</div>
				</div>
			</div>
		</div>
	</div>	
</div>
</div>

    </section>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
<script>
	$(function() {
		$("input[name='sea']").change(function(){
			if ($(this).val() == 'Category') {
				$('#catsec').show();
				$('#namesear').hide();
                $('#authorsear').hide();
			}
			else if ($(this).val() == 'Author') {
				$('#catsec').hide();
				$('#namesear').hide();
                $('#authorsear').show();
			}
            else if($(this).val() == 'BookName') {
				$('#catsec').hide();
				$('#namesear').show();
                $('#authorsear').hide();
			}
		});
	});

	$(document).ready(function(){
		$('#example').DataTable();
		$('.dataTables_length').addClass('bs-select');
	}); 

	function submit()
	{
		var bid = $('#reqbook').val();
		var sid = <?php echo $studentid;?>;
			$.ajax({
				type: "POST",
				url: "datahandle.php",
				data:{
					'register_request': true,
					'bid':bid,
					'sid':sid,
				},
				success: function (data) {
					document.getElementById('msg').style.display="block";
					$("#form-status").html(data);
				}
			});

	}
</script>
</html>
<?php } ?>