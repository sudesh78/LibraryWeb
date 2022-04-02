<?php
	$id = $_SESSION['login_pic'];
?> 
<style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');
*{
    list-style: none;
    text-decoration: none;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Open Sans', sans-serif;
}

body{
    background: #f5f6fa;
}

.wrapper .sidebar{
    background: rgb(5, 68, 104);
    position: fixed;
    top: 0;
    left: 0;
    width: 200px;
    height: 100%;
    padding: 20px 0;
    transition: all 0.5s ease;
}

.wrapper .sidebar .profile{
    margin-bottom: 30px;
    text-align: center;
}

.wrapper .sidebar .profile img{
    display: block;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    margin: 0 auto;
}

.wrapper .sidebar .profile h3{
    color: #ffffff;
    margin: 10px 0 5px;
}

.wrapper .sidebar .profile p{
    color: rgb(206, 240, 253);
    font-size: 14px;
}

.wrapper .sidebar ul li a{
    display: block;
    padding: 13px 30px;
    border-bottom: 1px solid #10558d;
    color: rgb(241, 237, 237);
    font-size: 16px;
    position: relative;
}

.wrapper .sidebar ul li a .icon{
    color: #dee4ec;
    width: 30px;
    display: inline-block;
}

.wrapper .sidebar ul li a:hover,
.wrapper .sidebar ul li a.active{
    color: #0c7db1;

    background:white;
    border-right: 2px solid rgb(5, 68, 104);
}

.wrapper .sidebar ul li a:hover .icon,
.wrapper .sidebar ul li a.active .icon{
    color: #0c7db1;
}

.wrapper .sidebar ul li a:hover:before,
.wrapper .sidebar ul li a.active:before{
    display: block;
}

.wrapper .section{
    width: calc(100% - 200px);
    margin-left: 200px;
    transition: all 0.5s ease;
}

.wrapper .section .top_navbar{
    background: rgb(7, 105, 185);
    height: 90px;
    display: flex;
    align-items: center;
    padding: 0 30px;

}

.wrapper .section .top_navbar .hamburger a{
    font-size: 28px;
    color: #f4fbff;
}

.wrapper .section .top_navbar .hamburger a:hover{
    color: #a2ecff;
}



body.active .wrapper .sidebar{
    left: -225px;
}

body.active .wrapper .section{
    margin-left: 0;
    width: 100%;
}

.lib{
    font-size: 22px;
    margin-top:18px;
    margin-left:10px;

}

.section a:hover{
    color: #b5ac8e;
    text-decoration: none;
}
</style>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">

<div class="wrapper">
    <div class="section">
            <div class="top_navbar">
            <div class="left" style="display: flex;">
		<a class="logo" href="admin_dashboard.php" style="text-decoration: none;">
				<img class="rounded-circle z-depth-0" src="img/logo top.jpg" width="70" height="70">
			</a>
			<a class="navbar-brand1 lib" href="admin_dashboard.php">Library Management System</a>
		</div>
            </div>

        </div>
        <div class="sidebar">
            <div class="profile">
                <img src="<?php echo($id); ?>" alt="profile_picture">
                <h3><?php echo($_SESSION['login_name']); ?></h3>
                <p><?php echo($_SESSION['user']); ?></p>
            </div>
            <ul>
                <li>
                    <a href="st_dashboard.php" class="active">
                        <span class="icon"><i class="fas fa-home"></i></span>
                        <span class="item">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="st_search.php">
                        <span class="icon"><i class="fas fa-desktop"></i></span>
                        <span class="item">Search</span>
                    </a>
                </li>
                <li>
                    <a href="st_issuedbook.php">
                        <span class="icon"><i class="fas fa-user-friends"></i></span>
                        <span class="item">Issued Book</span>
                    </a>
                </li>
                <li>
                    <a href="st_historybook.php">
                        <span class="icon"><i class="fas fa-tachometer-alt"></i></span>
                        <span class="item">Issued History</span>
                    </a>
                </li>
                <li>
                    <a href="st_requests.php">
                        <span class="icon"><i class="fas fa-database"></i></span>
                        <span class="item">Requests</span>
                    </a>
                </li>

                <li>
                    <a href="logout.php">
                        <span class="icon"><i class="fas fa-power-off"></i></span>
                        <span class="item">LOG OUT</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <script>
      var hamburger = document.querySelector(".hamburger");
    hamburger.addEventListener("click", function(){
        document.querySelector("body").classList.toggle("active");
    })
</script>
