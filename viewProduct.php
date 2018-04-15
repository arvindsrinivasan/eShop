<?php
  include 'dbConfig.php';
  include 'Cart.php';
$cart = new Cart;

// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 && $_POST['id']) {
  $_SESSION['message'] = "You must log in before viewing your profile page!";
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
}

  $pid = $_POST['id'];
  $query = $db->query("SELECT * FROM products WHERE id = '$pid'");

  $details = mysqli_fetch_row($query);

  $dealers = $db->query("SELECT dealer FROM dealers WHERE product_id = '$pid'");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Welcome <?= $first_name.' '.$last_name?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/bootstrap-3.3.7/css/bootstrap.min.css">
    <script src="/jquery.min.js"></script>
    <script src="/bootstrap-3.3.7/js/bootstrap.min.js"></script>
    <style>
    .container{padding: 0px;}
    body{ background-color: #EEEEEE}
    .glyphicon .badge .navbar{font-size: 17px;}
    .navbar{font-size: 17px;}
    .badge{font-size: 17px;}
    </style>
</head>
<body>
  <nav class="navbar navbar-inverse"  style="border-radius: 0px;">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">E-Shop</a>
      </div>
      <ul class="nav navbar-nav">
        <li class="active"><a href="home.php">Home</a></li>
        <li><a href="messages.php">Messages</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> <?= $first_name?></a></li>
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        <li><a href="viewCart.php" title="View Cart">
          <span class="glyphicon glyphicon-shopping-cart"></span> Cart:
          <span class="badge"><?php echo $cart->total_items();?></span>
        </a></li>
      </ul>
    </div>
  </nav>

<div class="container">
  <div class="col-md-12">
  <div class="row">
    <h1> <?php echo $details[1] ?> </h1>    
  </div>

<div class="row">
<img src = "img/<?php echo $details[2] ?>"  style='float: left; margin: 2.5%'/>

<h2> Description </h2>
<p> <?php echo $details[3] ?> </p>

<h2> Dealers </h2>

<ul>
<?php
  while($row = $dealers->fetch_assoc()){

?>

<li> <?php echo $row['dealer'] ?> </li>

<?php } ?>
</ul>
</div>
<div class="row">
<div class="col-md-6" style='float: middle;'>
    <p class="lead"><?php echo '$'.$details[4].' USD'; ?></p>
</div>
<div class="col-md-6" style='float: right;'>
    <a class="btn btn-success" href="cartAction.php?action=addToCart&id=<?php echo $pid; ?>">Add to cart</a>
</div>



<br><br><br>
  </div>
<h2> Reviews </h2>

<table class="table table-hover">
<thead>
  <tr>
    <th>Customer Name</th>
    <th>Review</th>
  </tr>
  </thead>
  <tbody>

  <?php
    $query = $db->query("SELECT * FROM reviews WHERE product_id = '".$details[0]."'");
    $flag = 0;
    while($row = $query->fetch_assoc()){
      $flag = 1;
  ?>

  <tr>
    <td> <?php echo $row['customer_name'] ?></td>
    <td> <?php echo $row['review'] ?> </td>
  </tr>

  <?php
    }
    if (!$flag){
      ?> <p> There are no reviews for this product </p> <?php
    }
   ?>
   </tbody>
</table>

<h1> Review this product </h1>
<form class="form-horizontal" action = "reviewProduct.php" method = "GET">
<div class="form-group">
    <div class="col-sm-10">
          <textarea rows="3" class="form-control" name="review"
           id="review" placeholder="Enter Review"></textarea>
        </div>
        </div>
        
  <input type = "hidden" name = "pid" value = "<?php echo $pid ?>"/>
  <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default">Post</button>
        </div>
      </div>
  <!-- <input type = "submit" value = "Post"/> -->
</form>
</div>
</div>
</body>

</html>
