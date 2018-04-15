<?php

// include database configuration file
include 'dbConfig.php';

if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
    if($_REQUEST['action'] == 'addToProducts'){
        // get product details
        // $query = $db->query("SELECT * FROM products WHERE id = ".$productID);
        // $row = $query->fetch_assoc();
        $s = $_POST;
        extract($_POST);
        $query = $db->query("INSERT INTO `products` (`name` , `img` ,`description`, `price`, `created`, `modified`) VALUES
        ('".$name."','".$image."', '".$description."',".$price.", '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."');");

        $result = $db->query("SELECT `id` FROM `products` WHERE `name` = '$name' AND `img` = '$image' AND `description` = '$description' AND `price` = '$price' AND `created` = '".date("Y-m-d H:i:s")."'");

        $namewords = explode(" ", $name);

        foreach($result as $id)
        {
             foreach($keywords as $key){
                  $query = $db->query("INSERT INTO `keywords` VALUES (".$id['id'].", '".strtolower($key)."')");
             }
             foreach($namewords as $key){
                  $query = $db->query("INSERT INTO `keywords` VALUES (".$id['id'].", '".strtolower($key)."')");
             }
        }

        header("Location: admin.php");
    }
    }else{
        header("Location: home.php");
    }
