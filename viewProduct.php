<?php
  include 'dbConfig.php';

  session_start();

  $pid = $_POST['id'];
  $query = $db->query("SELECT * FROM products WHERE id = '$pid'");

  $details = mysqli_fetch_row($query);

?>

<html>

  <h1> <?php echo $details[1] ?> </h1>

  <h2> Description <h2>
  <h3> <?php echo $details[2] ?> </h3>

  <br><br><br>

  <h2> Reviews </h2>

  <table>

    <tr>
      <th>Customer Name</th>
      <th>Review</th>
    </tr>

    <?php
      $query = $db->query("SELECT * FROM reviews WHERE product_id = '".$details[0]."'");
      while($row = $query->fetch_assoc()){
    ?>

    <tr>
      <td> <?php echo $row['customer_name'] ?></td>
      <td> <?php echo $row['review'] ?> </td>
    </tr>

    <?php
      }
     ?>
  <table>

</html>
