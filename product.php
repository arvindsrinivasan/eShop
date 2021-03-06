<?php
/* Displays user information and some useful messages */
session_start();
include 'db.php';
// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ||  $_SESSION['email']!=='admin@eshop.com') {
  $_SESSION['message'] = "You must log in as an admin to view this page!";
  header("location: error.php");
}
else {
    // Makes it easier to read
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
    $address = $_SESSION['address'];
    $phone = $_SESSION['phone'];
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add product</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/bootstrap-3.3.7/css/bootstrap.min.css">
    <script src="/jquery.min.js"></script>
    <script src="/bootstrap-3.3.7/js/bootstrap.min.js"></script>
    <style>
    .container{padding: 0px;}
    body{ background-color: #EEEEEE}
    .glyphicon .badge .navbar{font-size: 17px;}
    .navbar{font-size: 17px;}
    .badge{font-size: 17px;}
    th, td {padding: 15px;text-align: center;}
    table, th, td {border: 2px solid black;}
    input[type="number"]{width: 20%;}
    </style>

</head>
</head>
<body>
  <nav class="navbar navbar-inverse"  style="border-radius: 0px;">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">E-Shop</a>
      </div>
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="messages.php">Messages</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?= $first_name?></a></li>
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </a></li>
      </ul>
    </div>
  </nav>

  <div class="container" style="margin:40px">

    <form class="form-horizontal" method="post" action="addproduct.php?action=addToProducts">
      <div class="form-group">
        <label class="control-label col-sm-2" for="name">Product name:</label>
        <div class="col-sm-10">
          <input type="text" required class="form-control" name="name" id="name" placeholder="Enter Name">
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-2" for="image">Product image:</label>
        <div class="col-sm-10">
          <input type="text" required class="form-control"
          name="image" id="image" placeholder="Enter the name of the img file (Put the file in the Img folder first)">
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-2" for="description">Product description:</label>
        <div class="col-sm-10">
          <textarea required rows="3" class="form-control" name="description"
           id="description" placeholder="Enter description"></textarea>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-2" for="dealers">Dealers:</label>
        <div class="col-sm-10">
          <input type="text" required class="form-control"
          name="dealers" id="dealers" placeholder="Enter the names of dealers (separated by commas)">
        </div>
      </div>

      <div class="form-group">
          <label class="control-label col-sm-2">Keywords:</label>
          <div class="col-sm-4">
              <input type="text" class="form-control" name="keywords[]" />
          </div>
          <div class="col-xs-4">
              <button type="button" class="btn btn-default addButton glyphicon glyphicon-plus" id = "addBtn"><i class="fa fa-plus"></i></button>
          </div>
      </div>

      <div id = "keys">

      </div>

      <div class="form-group">
        <label class="control-label col-sm-2" for="price">Product price:</label>
        <div class="col-sm-10">
          <input type="number" required class="form-control" name="price" id="price" step="any" placeholder="Enter price">
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default">Submit</button>
        </div>
      </div>
    </form>
  </div>

</div>
</body>

<script>
var keys = document.getElementById("keys");
var addBtn = document.getElementById("addBtn");
var count = 0;
addBtn.addEventListener("click", function(){
  s = `
  <div class="form-group" id="optionTemplate">
      <div class="col-sm-offset-2 col-sm-4">
          <input class="form-control" type="text" name="keywords[]" />
      </div>
      <div class="col-xs-4" id = "` + count + `">
          <button type="button" onclick = "removeField(` + count + `)" class="btn btn-default removeButton glyphicon glyphicon-minus"><i class="fa fa-minus"></i></button>
      </div>
  </div>
  `;
  count += 1;
  var curr = keys.innerHTML;
  var n = curr + s;
  keys.innerHTML = n;
});

  function removeField(count){
    var btn = document.getElementById(count);
    keys.removeChild(btn.parentNode);
  }

</script>

</html>
