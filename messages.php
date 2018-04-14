<?php
include 'dbConfig.php';
session_start();
//print_r($_SESSION);
//echo($_SESSION['sessCustomerID']);

$user = $_SESSION['sessCustomerID'];
?>

<html>
  <head>

  </head>

  <body>

    <h1> Messages </h1>
    <table>

      <tr>
        <th>Sender</th>
        <th>Receiver</th>
        <th>Message</th>
        <th>Body</th>
      </tr>

      <?php
        $query = $db->query("SELECT * FROM messages WHERE sender_id = $user OR receiver_id = $user ORDER BY send_time DESC");

        while($row = $query->fetch_assoc()){
      ?>


      <tr>
        <td><?php echo $row['sender_id'] ?></td>
        <td><?php echo $row['receiver_id'] ?></td>
        <td><?php echo $row['subject'] ?></td>
        <td><?php echo $row['body'] ?></td>
        <td><?php echo $row['send_time'] ?></td>
      </tr>

    <?php } ?>
    </table>
    <br><br><br>
    <h1> Send Message </h1>
    <form action = "sendMessage.php" method = "GET">
      <input type = "email" name = "email" placeholder= "Email"/>
      <input type = "text" name = "subject" placeholder = "Subject"/>
      <input type = "textarea" name = "body" placeholder = "Message">
      <input type = "submit" value = "Send"/>
    </form>
  </body>
</html>
