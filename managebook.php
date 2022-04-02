<?php 
   $conn = mysqli_connect("localhost", "root","", "librarymanage");
   session_start();
   if(strlen($_SESSION['login'])==0)
   {
     header("location: login.php");
   }
   else
   {
   $bid = $_GET['bid'];
   $query = "SELECT * FROM books where b_id='$bid' ";
   $query_run = mysqli_query($conn,$query);
   $result = mysqli_fetch_array($query_run);
   
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" type="text/css" href="css/nav.css">
      <link rel="stylesheet" type="text/css" href="css/navbar.css">
      <link rel="stylesheet" type="text/css" href="css/mangaebook.css">
      <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">
     
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
     
      <!-- JS Files -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>
      <title>Document</title>
   </head>
   <style>
       #profiledis,.edit{
            cursor: pointer;
       }
       .centered {
            position: absolute;
            top: 8px;
            right: 16px;
        }
   </style>
   <body>
      <?php include("sidenav.php") ?>
      <div style="position: relative;left:200px;" >
      <?php include("admin_nav.php") ?>
    </div>
         <div class="main">
            <div class="form f">
               <form role="form" method="post" enctype="multipart/form-data" action="datahandle.php">
                  <input type='hidden' name='bid' id='bid' value="<?php echo $result['b_id']; ?>">
                  <div class="form-group text-center" style="position: relative;" >
                     <span class="img-div">
                        <div class="text-center centered"  onClick="triggerClck()">
                           <i class="fa fa-pen edit"></i>
                        </div>
                        <img src="<?php echo $result['cover']; ?>" onClick="triggerClck()" style="width: 100%;" id="profiledis">
                     </span>
                     <input type="hidden" id="fakepic" name="fakepic" value="<?php echo $result['cover']; ?>">	
                     <input type="file" name="profileImg" onChange="displayImg(this)" id="profileImg" value="" class="form-control" style="display: none;">
                  </div>
                  <div class="form-group ">
                     <label>Book Name<span style="color:red;">*</span></label>
                     <input class="form-control" style="height: 35px;" type="text" name="bookname"
                        value="<?php echo $result['name']; ?>" required />
                  </div>
                  <div class="form-group ">
                     <label> Category<span style="color:red;">*</span></label>
                     <select class="form-control"style="height: 35px;" name="category" required="required" >
                        <option value="0">Select Category</option>
                        <?php 
                           $qry = $conn->query("SELECT * FROM category");
                           while($row= $qry->fetch_assoc()):
                             ?>
                        <option value="<?php echo $row['c_id'] ?>" <?php if($result['categoryid']==$row['c_id']) echo 'selected="selected"'; ?> ><?php echo $row['name'] ?></option>
                        <?php endwhile; ?>
                     </select>
                  </div>
                  <div class="form-group ">
                     <label> Author<span style="color:red;">*</span></label>
                     <input type="text" class="form-control " value=""  style="height: 35px;" name="eauthor" id="eauthor">
                     </input>
                  </div>
                  <div class="form-group">
                     <label>ISBN Number<span style="color:red;">*</span></label>
                     <input class="form-control tr " type="text" style="height: 35px;" name="isbn"
                        value="<?php echo $result['isbn']; ?>" required="required" />
                     <p class="help-block">An ISBN is an International Standard Book Number.ISBN Must be
                        unique
                     </p>
                  </div>
                  <div class="form-group">
                     <label>Price in USD<span style="color:red;">*</span></label>
                     <input class="form-control tr" type="text" name="price" style="height: 35px;"
                        value="<?php echo $result['price']; ?>" required="required" />
                  </div>
                  <div class="btns" style="display: inline-block;margin: 0 20%;">
                     <button type="submit" name="updatebook" class="btn btn-info">Update </button>
                     <a onclick="window.history.back(-1)" class="btn btn-danger"  >Cancel</a>               
                  </div>
               </form>
            </div>
         </div>
      </div>
   </body>
</html>
<?php 
   $result1 = $conn->query("SELECT * FROM authors");
   $result1->fetch_all(MYSQLI_ASSOC);
   ?>
<script>
   function triggerClck(e) {
  		document.querySelector('#profileImg').click();
	};

	function displayImg(e) {
  		if (e.files[0]) {
    		var reader = new FileReader();
    		reader.onload = function(e){
      			document.querySelector('#profiledis').setAttribute('src', e.target.result);
    		}
    	reader.readAsDataURL(e.files[0]);
  		}
	};
	
</script>
<script type="text/javascript">
   $("#eauthor").val("<?php echo $result['author'];?>");
   
      var data = [<?php foreach($result1 as $row) { ?>
               {id:"<?php echo $row['a_id']; ?>",value :"<?php echo $row['name']; ?>"}, 
               <?php } ?>];
       $(document).ready(function(){
         $('#eauthor').tokenfield({
           autocomplete:{
           source: data,
           },
           showAutocompleteOnFocus: true
         });
         $('#eauthor').on('tokenfield:createtoken', function (event) {
             var existingTokens = $(this).tokenfield('getTokens');
             $.each(existingTokens, function(index, token) {
                 if (token.value === event.attrs.value)
                     event.preventDefault();
             });
         });
   });
</script>
<?php } ?>