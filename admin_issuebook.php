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
$month = date('m');
$day = date('d')+21;
$year = date('Y');
$today = date('Y-m-d');
$return = date('Y-m-d', strtotime('21 days'));

if(isset($_POST['issuebook']))
{
    echo "Hello";
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
    top: 95px;

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
	<link href="css/manageuser.css" rel="stylesheet" type="text/css">
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
	
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
                    <div class="card-header"><span class="card-header-title" >Issue Book</span></div>
                    <div class="card-body">
                    <form id="submit_form">  
                        <div class="form-row mb-10">
                            <div class="mb-10 col-md col-6">
                                <div class="form-row mb-10">
                                    <div class="input-group"><div class="input-group-prepend "><span class="input-group-text ">Search Student-Id<a data-toggle="tooltip" data-placement="top" title="Try User Id : 370 or 369" class="pl-1"><i class="fas fa-info-circle"></i></a></span> </div>
                                    <input id="userid" placeholder="Type to search." type="text" class="form-control ui-autocomplete-input" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-3">
                                        <img id="user_image" src="https://via.placeholder.com/400X400" class="ui-state-default img-thumbnail">
                                    </div>
                                    <div class="col-md-9">     
                                        <input type="hidden" id="user_course_id">
                                        <input type="hidden" id="user_year_id">
                                        <ul class="list-group text-sm">
                                            <li class="list-group-item text-capitalize" style="padding-left: 7px;">User ID :
                                                <span class="user_field_val ren" id="spn_user_id" value="12313">N/A</span></li>
                                            <li class="list-group-item text-capitalize">Course : <span class="user_field_val ren" id="user_course">N/A</span>
                                                | Year :<span class="user_field_val ren" id="user_year">N/A</span>
                                            </li>
                                            <li class="list-group-item">Email : <span class="user_field_val ren" id="user_email">N/A</span>
                                            </li>
                                            <li class="list-group-item address_li">Mobile : <span class="user_field_val ren" id="user_mobile">N/A</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div  class="mb-10 col-md col-6">
                                    <div class="form-row mb-10">
                                        <div class="input-group"><div class="input-group-prepend "><span class="input-group-text ">Search Book-Isbn<a data-toggle="tooltip" data-placement="top" style="padding-left:5px;" title="Try Book Id : Type 97"><i class="fas fa-info-circle"></i></a></span> </div>
                                        <input id="book_isbn" placeholder="Type to search." type="text" class="form-control ui-autocomplete-input" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                  
                                    
                                        <div class="col-md-3">
                                            <img id="book_image" src="https://via.placeholder.com/400x400" class="ui-state-default img-thumbnail">
                                        </div>
                                        <div class="col-md-9">
                                            <ul class="list-group text-sm">
                            
                                                <li class="list-group-item text-capitalize">Book Title
                                                    : <span class="book_field_val ren" id="book_title">N/A</span>
                                                </li>
                                                <li class="list-group-item text-capitalize">Category : <span class="book_field_val ren" id="book_category">N/A
                                        </span> | Book Price : <span class="book_field_val ren" id="book_price">N/A</span>
                                                </li>
                                                <li class="list-group-item text-capitalize" style="padding-left: 7px;">
                                                    Book ISBN : <span class="book_field_val ren" id="book_span_isbn">N/A</span>
                                                </li>
                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="form-row mb-10">
                            <div wire:ignore="" class="col-md mb-10">
                                <div class="input-group"><div class="input-group-prepend "><span class="input-group-text ">Issue Date</span> </div>
                                <input type="date" id="issue_date_tmp"  value="<?php echo $today;?>" class="form-control hasDatepicker">
                            
                                </div>
                            </div>
                            <div wire:ignore="" class="col-md mb-10">
                                <div class="input-group"><div class="input-group-prepend "><span class="input-group-text ">Return Date</span> </div>
                                <input type="date" id="return_date_tmp" class="form-control datepicker" value="<?php echo $return;?>">
        
                                </div>
                            </div>
                            <div class="col-md mb-10">
                                <input type="hidden" id="book_id" name="book_id">
                                <input type="hidden" id="user_id" name="user_id">
                                <input type="hidden" id="book_qty">
                                <input type="hidden" id="user_slot">
                                <input type="hidden" id="issue_date" value="<?php echo $today;?>">
                                <input type="hidden" id="return_date" value="<?php echo $return;?>">
                                <input type="button" name="issuebook" id="issuebook" disabled="disabled" value="Issue Book" class="btn btn-danger">
                            </form>  
                            </div>
                        </div>
        
 
                    </div>
    </div>
    <div class="card" style="top:90px;">
					<div class="card-header">
						<b>List of Issued Books</b>
						
				</a></span>
					</div>
					<div class="card-body" style="overflow-x: auto">
			<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
				<thead>
					<tr>
						<th class="text-center si">R_Id</th>
                        <th class="text-center si">Student ID</th>
						<th class="text-center si">Student Name</th>
                        <th class="text-center si">Book Name</th>
						<th class="text-center si ">ISBN</th>
						<th class="text-center si">RequestDate</th>
						<th class="text-center si">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$users = $conn->query("SELECT request.r_id,request.regdate,request.status,students.Studentid,students.Name as sname,books.b_id,books.name,books.cover,books.author,books.isbn FROM request JOIN students ON request.Studentid = students.Studentid JOIN books ON books.b_id= request.bookid where request.status=0 GROUP by request.regdate;");
						while($row= $users->fetch_assoc()):
					?>
					<tr class="text-center">
						<td class="ri">
							<?php $bid = $row['b_id'];
                            echo $row['r_id']?>
						</td class="ri">
                        <td class="ri">
						<?php $student = $row['Studentid'];
                        echo ucwords($row['Studentid']) ?>
						</td>
						<td class="ri">
						<?php echo ucwords($row['sname']) ?>
						</td>
						<td class="ri">
							<?php echo ucwords($row['name']) ?>
						</td>
						
						<td class="ri">
							<?php $isbnid = $row['isbn'];
                            echo $row['isbn'] ?>
						</td>
						<td class="ri">
							<?php echo date('d-m-Y', strtotime($row['regdate'])); ?>
						</td>
						<td class="ri">
							<button class="btn btn-sm btn-info reqapprov" data-id="<?php echo $row['r_id'] ?>" type="button"> Accept </button>
							<button class="btn btn-sm btn-danger declinereq" type="button" data-id="<?php echo $row['r_id'] ?>">Decline</button>
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
</body>
</html>

  <script>
        $(document).ready(function(){
            $('#example').DataTable();
		    $('.dataTables_length').addClass('bs-select');
            $('#issuebook').click(function(){  
                var s_id = $('#user_id').val();  
                var b_id = $('#book_id').val();
                var b_qty = $('#book_qty').val();  
                var s_slot = $('#user_slot').val();
                var i_date = $('#issue_date').val();  
                var r_date = $('#return_date').val();
                if($('#user_slot').val()>0)
                {
                    if($('#book_qty').val()>0)
                    {
                        $('#error_message').html('');  
                        $.ajax({  
                            url:"datahandle.php",  
                            method:"POST",  
                            data:{s_id:s_id, b_id:b_id,b_qty:b_qty,s_slot:s_slot,i_date:i_date,r_date:r_date},  
                            success:function(data){  
                                $('#form-status').html("<p class='success'>"+data+".</p>");  
                                document.getElementById('msg').style.display="block";
                                clearfun();
                            }  
                        });  
                    }
                    else{
                        $("#form-status").html("<p class='success'>Book Not Available.</p>");
                        document.getElementById('msg').style.display="block";
                        clearfun();
                    }
                }
                else{
                    $("#form-status").html("<p class='success'>User Slot Full.</p>");
                    document.getElementById('msg').style.display="block";
                    clearfun();
                    }
             }); 
             $(".decline-req").click(function(e)
             {
                e.preventDefault;
                var rid = $(this).attr("data-id");
                $("#del_id").val(sid);
            });

            $('.reqapprov').click(function(){
                var rid = $(this).attr("data-id");
                var bid = <?php echo $bid;?>;
                var bookisbn = <?php echo $isbnid;?>;
                var student = <?php echo $student;?>;
                var update = $('#issue_date').val();
                $('#error_message').html('');  
                $.ajax({  
                        url:"datahandle.php",  
                        method:"POST",  
                        data:{'rid':rid,'bid':bid,'sid':student,'isbn':bookisbn,'udate':update,'approvereq':true},  
                        success:function(data){  
                            $('#form-status').html("<p class='success'>"+data+".</p>");  
                            document.getElementById('msg').style.display="block";
                            clearfun();
                            setInterval('location.reload()', 2000);  
                        }  
                        });  
            });
            $('.declinereq').click(function(){
                var rid = $(this).attr("data-id");
                var update = $('#issue_date').val();
                $('#error_message').html('');  
                $.ajax({  
                        url:"datahandle.php",  
                        method:"POST",  
                        data:{'rid':rid,'udate':update,'declinereq':true},    
                        success:function(data){  
                            $('#form-status').html("<p class='success'>"+data+".</p>");  
                            document.getElementById('msg').style.display="block";
                            clearfun();
                            setInterval('location.reload()', 2000);  
                        }  
                        });  
            });
            var sidbtn = document.getElementById("userid");
            sidbtn.addEventListener("keypress", function (event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    var sid = $("#userid").val();
                    console.log(sid);
                    $.ajax({
                        type: "POST",
                        url: "datahandle.php",
                        data:{
                            'check_user': true,
                            'sid':sid,
                        },
                        success: function (response) {
                            if(response=='not')
                            {
                                $("#form-status").html("<p class='success'>Student Not Found.</p>");
                                document.getElementById('msg').style.display="block";
					            clearfun();   
                            }
                            else{
                                $.each(response,function(key,value)
                                {
                                    $('#user_id').val(value['Studentid']);
                                    $('#user_slot').val(value['book_slot']);
                                    $('#user_image').attr('src',value['photo']);
                                    $('#spn_user_id').text(value['Studentid']);
                                    $('#user_email').text(value['Emailid']);
                                    $('#spn_user_id').text(value['Studentid']);
                                    $('#user_mobile').text(value['Mobilenumber']);
                                    btncheck();
                                });
                            }
                        }
                    });
                }
            });

            var bisbn = document.getElementById('book_isbn');
            bisbn.addEventListener("keypress",function(e){
                if (event.keyCode == 13) {
                    event.preventDefault();
                    var isbn = $("#book_isbn").val();
                    $.ajax({
                        type: "POST",
                        url: "datahandle.php",
                        data:{
                            'check_book': true,
                            'isbn':isbn,
                        },
                        success: function (response) {
                            if(response =='not')
                            {
                                $("#form-status").html("<p class='success'>Book Not Found.</p>");
                                document.getElementById('msg').style.display="block";
                                clearfun();
                            }
                            else
                            {
                                $.each(response,function(key,value)
                                {
                                    $('#book_id').val(value['b_id']);
                                    $('#book_qty').val(value['quantity']);
                                    $('#book_image').attr('src',value['cover']);
                                    $('#book_span_isbn').text(value['isbn']);
                                    $('#book_title').text(value['name']);
                                    $('#book_price').text(value['price']);
                                    $('#book_category').text(value['catname']);
                                    $('#user_mobile').text(value['Mobilenumber']);
                                    btncheck();           
                                });
                            }
                            
                        }
                    });
                }
            });

        }); 

        function btncheck()
        {
            if($('#user_id').val() !='' && $('#book_id').val() !='')
            {
                $("input[id='issuebook']").removeAttr("disabled");
            
            }
        }

        function userinfo()
        {
            
        }

        function closse()
        {
            document.getElementById('msg').style.display="none";
        }
        function clearfun()
        {
            $("form").trigger("reset");  
            $(".ren").html("N/A");
            document.getElementById("book_image").src ="https://via.placeholder.com/400x400";
            document.getElementById("user_image").src ="https://via.placeholder.com/400x400";
        }

    </script>
<?php } ?>
