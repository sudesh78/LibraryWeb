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
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/nav.css">
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/font-awesome.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>
</head>
<style>
  #wrapper
{

 padding:0px;
 width:80%;
}
#output_image
{
 max-width:300px;
}
.cover{
  display: block;
    width: 100%;
    text-align: right;
}
.tr{
  padding: 0 5px;
}
</style>
<body>

  <?php include("sidenav.php") ?>
  <div style="position: relative;left:200px;" >
      <?php include("admin_nav.php") ?>
  </div>

  <div class="content-wrapper" style="background: #f5f5f5;">
      <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <div class="panel panel-info">
              <div class="panel-heading">Book Info</div>
              <div class="panel-body">
              <form role="form" method="post" action="datahandle.php" enctype="multipart/form-data">
                    <div class="form-group">
                      <div id="wrapper">
                      <label style="float: left;">Book Cover<span style="color:red;">*</span></label>
                        <input type="file" name="image" id="image">
                         <div class="cover" id="preview"></div> 

                        </div>
                    </div>
                  
                    <div class="form-group">
                      <label>Book Name<span style="color:red;">*</span></label>
                      <input class="form-control" type="text" name="bookname" autocomplete="off" style="
                      padding: 15px 0px;"/>
                    </div>
                    <div class="form-group">
                      <label> Category<span style="color:red;">*</span></label>
                      <select class="form-control" name="category" style="height: 34px;">
                          <option value="" >Select Category</option>
                            <?php 
                            $qry = $conn->query("SELECT * FROM category");
                            while($row= $qry->fetch_assoc()):
                              ?>
                              <option value="<?php echo $row['c_id'] ?>" ><?php echo $row['name'] ?></option>
                              <?php endwhile; ?>
                          </select>
                    </div>
                    <div class="form-group">
                      <label> Author<span style="color:red;">*</span></label>
                      <input type="text" id="author" name="author" class="form-control">
                    </div>

                    <div class="form-group">
                      <label>ISBN Number<span style="color:red;">*</span></label>
                      <input class="form-control" type="text" name="isbn" autocomplete="off" style="padding: 15px 0px;" />
                      <p class="help-block">An ISBN is an International Standard Book Number.ISBN Must be unique</p>
                    </div>

                    <div class="form-group">
                      <label>Price<span style="color:red;">*</span></label>
                      <input class="form-control" type="text" name="price" autocomplete="off" style="padding: 15px 0px;"/>
                    </div>
                    <div class="form-group" style="float: right;">
                      <button type="submit" name="add" class="btn btn-info">Add </button>
                      <a onclick="window.history.back(-1)" class="btn btn-danger">Cancel</a>
                    </div>

                  </form>
                </div>
              </div>
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

   var data = [<?php foreach($result as $row) { ?>
            {id:"<?php echo $row['a_id']; ?>",value :"<?php echo $row['name']; ?>"}, 
            <?php } ?>];
    $(document).ready(function(){
      $('#author').tokenfield({
        autocomplete:{
        source: data,
        },
        showAutocompleteOnFocus: true
      });
      $('#author').on('tokenfield:createtoken', function (event) {
          var existingTokens = $(this).tokenfield('getTokens');
          $.each(existingTokens, function(index, token) {
              if (token.value === event.attrs.value)
                  event.preventDefault();
          });
      });
      var new1 = $(this).attr('data-value');
      console.log(new1);
      var new2 = $('#author').val();
      console.log(new2);
});
</script>     
<script>
  function imagePreview(fileInput) {
    if (fileInput.files && fileInput.files[0]) {
        var fileReader = new FileReader();
        fileReader.onload = function (event) {
            $('#preview').html('<img src="'+event.target.result+'" width="300" height="auto"/>');
        };
        fileReader.readAsDataURL(fileInput.files[0]);
    }
}
$("#image").change(function () {
    imagePreview(this);
});

</script>
<?php } ?>

