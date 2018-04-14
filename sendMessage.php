<?php

  include 'dbConfig.php';

  session_start();
  extract($_GET);

  $sender_id = $_SESSION['sessCustomerID'];

  $query = $db->query("SELECT id FROM customers WHERE email = '$email'");
  while($row = $query->fetch_assoc()){
    $receiver_id = $row['id'];
  }


  $query = $db->query("INSERT INTO `messages` VALUES ($sender_id, $receiver_id, '$subject', '$body', '".date("Y-m-d H:i:s")."')");

  echo "INSERT INTO `messages` VALUES ($sender_id, $receiver_id, '$subject', '$body', '".date("Y-m-d H:i:s")."')";

  header("Location: messages.php");
?>
