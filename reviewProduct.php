<?php
  include 'dbConfig.php';

  session_start();

  extract($_GET);
  //print_r($_SESSION);

  $name = $_SESSION['first_name'];

  $query = $db->query("INSERT INTO `reviews` VALUES ('$name', $pid, '$review')");

  header("Location: home.php");
 ?>
