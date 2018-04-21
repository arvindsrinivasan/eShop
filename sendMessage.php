<?php

  include 'dbConfig.php';

  session_start();
  extract($_GET);

  print_r($_GET);

  $sender_id = $_SESSION['sessCustomerID'];

  $query = $db->query("INSERT INTO `messages` VALUES ($sender_id, $receiver_id, 'random', '$body', '".date("Y-m-d H:i:s")."')");

  //echo "INSERT INTO `messages` VALUES ($sender_id, $receiver_id, 'random', '$body', '".date("Y-m-d H:i:s")."')";

  header("Location: messages.php");
?>
