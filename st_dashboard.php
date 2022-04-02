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
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | User Dash Board</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
   
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/nav.css">
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php include("st_sidenav.php") ?>
    <div class="conta" style="width: calc(100% - 200px);">
    <?php include("st_nav.php") ?>
    </div>
    <div class="content-wrapper " style="left: 200px;position: relative;top: 100px;">
         <div class="container" style="display: block;position: absolute; left:150px;">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line"> DASHBOARD</h4>
                
                            </div>

        </div>
             
             <div class="row">
                 <div class="col-md-3 col-sm-3 col-xs-6">
                      <div class="alert alert-info back-widget-set text-center">
                            <i class="fa fa-bars fa-5x"></i>
                        <?php 
                        $sid=$_SESSION['stdid'];
                        $sql1 =$conn->query("SELECT i_id from issuedbook where Studentid=$sid");
                        $bissued = $sql1->num_rows;
                        ?>

                            <h3><?php echo $bissued;?> </h3>
                            Book Issued
                        </div>
                    </div>
                    <?php 
                        $sql2 =$conn->query("SELECT i_id from issuedbook where Studentid=$sid and returnstatus=1");
                        $bnoot = $sql2->num_rows;
                        ?>
             
               <div class="col-md-3 col-sm-3 col-xs-6">
                      <div class="alert alert-warning back-widget-set text-center">
                            <i class="fa fa-recycle fa-5x"></i>
                            <h3><?php echo $bnoot;?></h3>
                          Books Not Returned Yet
                        </div>
                    </div>
        </div>


            
    </div>

    </div>
</body>
</html>
<?php } ?>