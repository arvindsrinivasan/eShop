<?php
  include 'dbConfig.php';

  session_start();

  $pid = $_POST['id'];
  $query = $db->query("SELECT * FROM products WHERE id = '$pid'");

  $details = mysqli_fetch_row($query);

  $dealers = $db->query("SELECT dealer FROM dealers WHERE product_id = '$pid'");

?>

<html>

  <h1> <?php echo $details[1] ?> </h1>

  <h2> Description </h2>
  <p> <?php echo $details[3] ?> </p>
  <img src = "img/<?php echo $details[2] ?>" />

  <h2> Dealers </h2>

  <ul>
  <?php
    while($row = $dealers->fetch_assoc()){

  ?>

  <li> <?php echo $row['dealer'] ?> </li>

  <?php } ?>
  </ul>


  <br><br><br>

  <h2> Reviews </h2>

  <table>

    <tr>
      <th>Customer Name</th>
      <th>Review</th>
    </tr>

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
  </table>

  <h1> Review this product </h1>
  <form action = "reviewProduct.php" method = "GET">
    <input type = "textarea" name = "review" placeholder = "Review"/>
    <input type = "hidden" name = "pid" value = "<?php echo $pid ?>"/>
    <input type = "submit" value = "Post"/>
  </form>

</html>
