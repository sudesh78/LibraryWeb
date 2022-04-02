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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    

    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/nav.css">
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

  <?php include("sidenav.php") ?>
    <section class="home-section">

        <?php include("admin_nav.php") ?> 

    <div class="home-content"  style="top: 60px;padding-top: 0;">
      <div class="overview-boxes">
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Books</div>
            <div class="number"> <?php echo $conn->query("SELECT * FROM books")->num_rows ?></div>
            <div class="indicator">
              <a class="text" href="admin_view_book.php">show more</a>
            </div>
          </div>
          <img src="./icons/cardbook.png" class='bx bxs-cart-add cart two' ></img>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Issued Books</div>
            <div class="number"> <?php echo $conn->query("SELECT * FROM issuedbook where returnstatus=1")->num_rows ?></div>
            <div class="indicator">
              <a href="admin_issuedbook.php" class="text">show More</a>
            </div>
          </div>
          <img src="./icons/cardbook.png" class='bx bxs-cart-add cart two' ></img>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Members</div>
            <div class="number"><?php echo $conn->query("SELECT * FROM students")->num_rows ?></div>
            <div class="indicator">
            <a href="admin_users.php" class="text">show More</a>
            </div>
          </div>
          <img src="./icons/cardbook.png" class='bx bxs-cart-add cart two' ></img>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Fine</div>
            <div class="number">₹ <?php $res= $conn->query("SELECT sum(fine) as fine FROM issuedbook where returnstatus=0");
                                      if ($res->num_rows > 0) {
                                        // output data of each row
                                        while($row = $res->fetch_assoc()) {
                                          echo $row['fine'];
                                        }
                                      }
                                     ?></div>
            <div class="indicator">
              <a href="admin_issuedbook.php" class="text">show More</a>
            </div>
          </div>
          <img src="./icons/cardbook.png" class='bx bxs-cart-add cart two' ></img>
        </div>
      </div>
    <div class="mid-content">
      <div class="left-box"><img class = "leftboxpic" src="./img/dashboard.jpg" alt=""></div>
      <div class="overview-box2" style=" width: 25%;">
          <div class="box">
            <div class="box-topic">Requests</div>
              <div class="number"><?php echo $conn->query("SELECT * FROM request where status=0")->num_rows ?></div>
              <div class="indicator">
                <a href="admin_issuebook.php" class="text">show More</a>
              </div>
              <img src="./icons/cardbook.png" class='bx bxs-cart-add cart2' ></img>
          </div>
</div>
    </div>
    </div>
  </section>
</body>
</html>
<?php } ?>