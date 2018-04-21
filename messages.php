<?php
include 'dbConfig.php';
include 'Cart.php';
$cart = new Cart;
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'cart';

if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "You must log in before viewing your profile!";
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
$curr=$_SESSION['sessCustomerID'];
$currname="SELECT distinct first_name FROM customers WHERE id=$curr";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql1="SELECT first_name,sender_id,subject,send_time,body FROM messages,customers WHERE receiver_id=$curr and sender_id=id order by send_time";
$sql = "SELECT distinct first_name,id FROM customers,messages WHERE (id=sender_id AND receiver_id=$curr) OR (id=receiver_id and sender_id=$curr)";
$sql2="SELECT receiver_id,subject,body,send_time,first_name FROM messages,customers WHERE sender_id=$curr and sender_id=id order by send_time";
$sql3="SELECT first_name,email,id from customers";
$result = $conn->query($sql);

$array = array();
$array1=array();
while($row = $result->fetch_assoc()){
  $array[] = $row;

}
 // show all array data
// echo $array[0]['username'];
$result1 = $conn->query($sql1);


$array1=array();
while($row = $result1->fetch_assoc()){
  $array1[] = $row;

}
//print_r($array1);
$result2 = $conn->query($sql2);


$array2=array();
while($row = $result2->fetch_assoc()){
  $array2[] = $row;

}

$result3 = $conn->query($sql3);


$array3=array();
while($row = $result3->fetch_assoc()){
  $array3[] = $row;

}
// print_r($array1);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com    @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <!--
    	The codes are free, but we require linking to our web site.
    	Why to Link?
    	A true story: one girl didn't set a link and had no decent date for two years, and another guy set a link and got a top ranking in Google!
    	Where to Put the Link?
    	home, about, credits... or in a good page that you want
    	THANK YOU MY FRIEND!
    -->
    <title>Messages</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
    	body {
  padding-top: 0;
  font-size: 12px;
  color: #777;
  background: #f9f9f9;
  font-family: 'Open Sans',sans-serif;
  margin-top:20px;
}

.bg-white {
  background-color: #fff;
}

.friend-list {
  list-style: none;
margin-left: -40px;
}

.friend-list li {
  border-bottom: 1px solid #eee;
}

.friend-list li a img {
  float: left;
  width: 45px;
  height: 45px;
  margin-right: 0px;
}

 .friend-list li a {
  position: relative;
  display: block;
  padding: 10px;
  transition: all .2s ease;
  -webkit-transition: all .2s ease;
  -moz-transition: all .2s ease;
  -ms-transition: all .2s ease;
  -o-transition: all .2s ease;
}

.friend-list li.active a {
  background-color: #f1f5fc;
}

.friend-list li a .friend-name,
.friend-list li a .friend-name:hover {
  color: #777;
}

.friend-list li a .last-message {
  width: 65%;
  white-space: nowrap;
  text-overflow: ellipsis;
  overflow: hidden;
}

.friend-list li a .time {
  position: absolute;
  top: 10px;
  right: 8px;
}

small, .small {
  font-size: 85%;
}

.friend-list li a .chat-alert {
  position: absolute;
  right: 8px;
  top: 27px;
  font-size: 10px;
  padding: 3px 5px;
}

.chat-message {
  padding: 60px 20px 115px;
}

.chat {
    list-style: none;
    margin: 0;
}

.chat-message{
    background: #f9f9f9;
}

.chat li img {
  width: 45px;
  height: 45px;
  border-radius: 50em;
  -moz-border-radius: 50em;
  -webkit-border-radius: 50em;
}

img {
  max-width: 100%;
}

.chat-body {
  padding-bottom: 20px;
}

.chat li.left .chat-body {
  margin-left: 70px;
  background-color: #fff;
}

.chat li .chat-body {
  position: relative;
  font-size: 11px;
  padding: 10px;
  border: 1px solid #f1f5fc;
  box-shadow: 0 1px 1px rgba(0,0,0,.05);
  -moz-box-shadow: 0 1px 1px rgba(0,0,0,.05);
  -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
}

.chat li .chat-body .header {
  padding-bottom: 5px;
  border-bottom: 1px solid #f1f5fc;
}

.chat li .chat-body p {
  margin: 0;
}

.chat li.left .chat-body:before {
  position: absolute;
  top: 10px;
  left: -8px;
  display: inline-block;
  background: #fff;
  width: 16px;
  height: 16px;
  border-top: 1px solid #f1f5fc;
  border-left: 1px solid #f1f5fc;
  content: '';
  transform: rotate(-45deg);
  -webkit-transform: rotate(-45deg);
  -moz-transform: rotate(-45deg);
  -ms-transform: rotate(-45deg);
  -o-transform: rotate(-45deg);
}

.chat li.right .chat-body:before {
  position: absolute;
  top: 10px;
  right: -8px;
  display: inline-block;
  background: #fff;
  width: 16px;
  height: 16px;
  border-top: 1px solid #f1f5fc;
  border-right: 1px solid #f1f5fc;
  content: '';
  transform: rotate(45deg);
  -webkit-transform: rotate(45deg);
  -moz-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  -o-transform: rotate(45deg);
}

.chat li {
  margin: 15px 0;
}

.chat li.right .chat-body {
  margin-right: 70px;
  background-color: #fff;
}

.chat-box {
  position: fixed;
  bottom: 0;
  left: 444px;
  right: 0;
  padding: 15px;
  border-top: 1px solid #eee;
  transition: all .5s ease;
  -webkit-transition: all .5s ease;
  -moz-transition: all .5s ease;
  -ms-transition: all .5s ease;
  -o-transition: all .5s ease;
}

.primary-font {
  color: #3c8dbc;
}

a:hover, a:active, a:focus {
  text-decoration: none;
  outline: 0;
}
    </style>
</head>
<body>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
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
<div class="container bootstrap snippet">
    <div class="row">
		<div class="col-md-4 bg-white ">
            <div class=" row border-bottom padding-sm" style="height: 40px;">

            </div>

            <!-- =============================================================== -->
            <!-- member list -->
            <ul class="friend-list">

            </ul>
		</div>

        <!--=========================================================-->
        <!-- selected chat -->
    	<div class="col-md-8 bg-white ">
            <div class="chat-message">
                <ul class="chat">
                    <!-- <li class="left clearfix">
                    	<span class="chat-img pull-left">
                    		<img src="https://bootdey.com/img/Content/user_3.jpg" alt="User Avatar">
                    	</span>
                    	<div class="chat-body clearfix">
                    		<div class="header">
                    			<strong class="primary-font">John Doe</strong>
                    			<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 12 mins ago</small>
                    		</div>
                    		<p>
                    			Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    		</p>
                    	</div>
                    </li>
                    <li class="right clearfix">
                    	<span class="chat-img pull-right">
                    		<img src="https://bootdey.com/img/Content/user_1.jpg" alt="User Avatar">
                    	</span>
                    	<div class="chat-body clearfix">
                    		<div class="header">
                    			<strong class="primary-font">Sarah</strong>
                    			<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 13 mins ago</small>
                    		</div>
                    		<p>
                    			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales at.
                    		</p>
                    	</div>
                    </li>
                    <li class="left clearfix">
                        <span class="chat-img pull-left">
                    		<img src="https://bootdey.com/img/Content/user_3.jpg" alt="User Avatar">
                    	</span>
                    	<div class="chat-body clearfix">
                    		<div class="header">
                    			<strong class="primary-font">John Doe</strong>
                    			<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 12 mins ago</small>
                    		</div>
                    		<p>
                    			Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    		</p>
                    	</div>
                    </li>
                    <li class="right clearfix">
                        <span class="chat-img pull-right">
                    		<img src="https://bootdey.com/img/Content/user_1.jpg" alt="User Avatar">
                    	</span>
                    	<div class="chat-body clearfix">
                    		<div class="header">
                    			<strong class="primary-font">Sarah</strong>
                    			<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 13 mins ago</small>
                    		</div>
                    		<p>
                    			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales at.
                    		</p>
                    	</div>
                    </li>
                    <li class="left clearfix">
                        <span class="chat-img pull-left">
                    		<img src="https://bootdey.com/img/Content/user_3.jpg" alt="User Avatar">
                    	</span>
                    	<div class="chat-body clearfix">
                    		<div class="header">
                    			<strong class="primary-font">John Doe</strong>
                    			<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 12 mins ago</small>
                    		</div>
                    		<p>
                    			Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    		</p>
                    	</div>
                    </li>
                    <li class="right clearfix">
                        <span class="chat-img pull-right">
                    		<img src="https://bootdey.com/img/Content/user_1.jpg" alt="User Avatar">
                    	</span>
                    	<div class="chat-body clearfix">
                    		<div class="header">
                    			<strong class="primary-font">Sarah</strong>
                    			<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 13 mins ago</small>
                    		</div>
                    		<p>
                    			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales at.
                    		</p>
                    	</div>
                    </li>
                    <li class="right clearfix">
                        <span class="chat-img pull-right">
                    		<img src="https://bootdey.com/img/Content/user_1.jpg" alt="User Avatar">
                    	</span>
                    	<div class="chat-body clearfix">
                    		<div class="header">
                    			<strong class="primary-font">Sarah</strong>
                    			<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 13 mins ago</small>
                    		</div>
                    		<p>
                    			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales at.
                    		</p>
                    	</div>
                    </li> -->
                  </ul>
                  </div>
            <form method="get" action="sendMessage.php">
            <div class="chat-box bg-white">
            	<div class="input-group"><input class="form-control border no-shadow no-rounded" placeholder="Type your message here" name = "body" type="text" required="required"></input>
              <div class="input-group">  <input type = "hidden" name = "receiver_id" id = "inp" value = ""/> </div>

            		<span class="input-group-btn"><input class="btn btn-success no-rounded" type="submit" value="send"></input>

            		</span>
            	</div><!-- /input-group -->
            </div>
          </form>

		</div>
	</div>
</div>

<script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript">
 var a = <?php echo json_encode($array); ?>;
  var customers = <?php echo json_encode($array3); ?>;
 var currname = <?php echo json_encode($currname); ?>;
 var messages = <?php echo json_encode($array1); ?>;
  var smessages = <?php echo json_encode($array2); ?>;
 var bdiv=document.querySelector('.friend-list');
 var activeid=<?php echo json_encode($curr); ?>;
 var z=document.querySelector('.chat');
 var max=Math.max(smessages.length,messages.length);
 var send=document.querySelector(".input-group-btn");
 var ip=document.querySelector(".input-group")
 var tmessages=messages.concat(smessages)
 var form=document.querySelector(form);
//  tmessages=tmessages.sort(function(a,b){
//   // Turn your strings into dates, and then subtract them
//   // to get a value that is either negative, positive, or zero.
//   return b['send_time'].getTime() -  a['send_time'].getTime();
// });
// tmessages.sortBy(function(o){ return new Date( o.date ) });
tmessages.sort(function(x, b) {
    x = new Date(x['send_time']);
    b = new Date(b['send_time']);
    console.log(x)
    return x-b
});
 // send.firstChild.addEventListener("submit",chat3);
 console.log(tmessages)
 console.log(messages)
 window.addEventListener("load",Setup);
 function Setup()
 {
   new_mem();
   for (var i = 0; i < a.length; i++) {
     addFriend(a[i])
   }
 }
 function addFriend(e)
 {
   var li1=document.createElement('li');
   li1.className="bounceInDown"
   li1.id=e['id'];
   li1.addEventListener("click",Display);
   var a1=document.createElement('a');
   a1.className="clearfix"
   a1.href="#";
   a1.id=e['id'];
   var img1=document.createElement('img');
   img1.src="https://bootdey.com/img/Content/user_1.jpg"
   img1.className="img-circle"
   img1.id=e['id'];
   var div1=document.createElement('div');
   div1.class="friend-name"
   var strong1=document.createElement('strong');
   strong1.innerHTML=e['first_name'];
   bdiv.appendChild(li1)
   li1.appendChild(a1)
   a1.appendChild(div1)
   a1.appendChild(img1)
   div1.appendChild(strong1)
 }
 function Display(e)
 {
   while (z.firstChild ) {
    z.removeChild(z.firstChild);
    console.log(z.firstChild)

}

// e.target.className="active";
console.log(e.target);
var inp = document.getElementById("inp");
inp.value = e.target.id;
//console.log(e['id']);
var c1 = 0;
var c2 = 0;
for(var i=0;i<tmessages.length;i++)
{
  if(e.target.id==tmessages[i]['sender_id'])
  {
    chats(tmessages[i]);

    console.log(1);
  }
  if(e.target.id==tmessages[i]['receiver_id'] )
  {
    chats1(tmessages[i]);

    console.log(1);
  }
}
// for (var i = 0; i < messages.length + smessages.length; i++) {
//
// // while(messages[i]['send_time']<=smessages[i]['send_time'])
// // {
//
//
//   if(c1<messages.length)
//   {
//   if(e.target.id==messages[c1]['sender_id'])
//   {
//     chats(messages[c1]);
//
//     console.log(1);
//   }
//   c1++;
// }
//
// // }
// // while(smessages[i]['send_time']<messages[i]['send_time'])
// // {
//   if(c2<smessages.length)
//   {
//   if(e.target.id==smessages[c2]['receiver_id'] && c2<smessages.length)
//   {
//     chats1(smessages[c2]);
//
//     console.log(1);
//   }
//   c2++;
// }
//
// // }
// }
 }
 function chats(e)
 {

   var li2=document.createElement('li')
   li2.className="left clearfix"
   var span1=document.createElement('span')
   span1.className="chat-img pull-left"
   var img2=document.createElement('img');
   img2.src="https://bootdey.com/img/Content/user_1.jpg"
   var div2=document.createElement('div')
   div2.className="chat-body clearfix"
   var div3=document.createElement('div')
   div3.className="header"
   var strong2=document.createElement('strong');
   strong2.className="primary-font"
   strong2.innerHTML=e['first_name']
   var small1=document.createElement('small')
   small1.className="pull-right text-muted"
   small1.innerHTML=e['send_time']
   var i1=document.createElement('i')
   i1.className="fa fa-clock-o"
   var p1=document.createElement('p')
   p1.innerHTML=e['body']
   z.appendChild(li2)
   li2.appendChild(span1)
   span1.appendChild(img2)
   li2.appendChild(div2)
   div2.appendChild(div3)
   div3.appendChild(strong2)
   div3.appendChild(small1)
   small1.appendChild(i1)
   div2.appendChild(p1)

  }
  function chats1(e)
  {

    var li2=document.createElement('li')
    li2.className="right clearfix"
    var span1=document.createElement('span')
    span1.className="chat-img pull-right"
    var img2=document.createElement('img');
    img2.src="https://bootdey.com/img/Content/user_1.jpg"
    var div2=document.createElement('div')
    div2.className="chat-body clearfix"
    var div3=document.createElement('div')
    div3.className="header"
    var strong2=document.createElement('strong');
    strong2.className="primary-font"
    strong2.innerHTML="You"
    var small1=document.createElement('small')
    small1.className="pull-right text-muted"
    small1.innerHTML=e['send_time']
    var i1=document.createElement('i')
    i1.className="fa fa-clock-o"
    var p1=document.createElement('p')
    p1.innerHTML=e['body']
    z.appendChild(li2)
    li2.appendChild(span1)
    span1.appendChild(img2)
    li2.appendChild(div2)
    div2.appendChild(div3)
    div3.appendChild(strong2)
    div3.appendChild(small1)
    small1.appendChild(i1)
    div2.appendChild(p1)

   }
   function chat3()
   {
    Display()
   }

   function new_mem()
   {
     var button=document.createElement('button');
     button.className="btn btn-success no-rounded"
     button.type=button;
     button.innerHTML="New Chat";
     bdiv.appendChild(button)
     button.addEventListener("click",new1);
   }
   function new1()
   {
     var ab=prompt("Enter email address of sender");
     for(var i=0;i<customers.length;i++)
     {
       if(ab==customers[i]['email'])
       {
          addFriend(customers[i])
       }
     }
   }
</script>
</body>
</html>
<!-- <div class="chat-box bg-white">
  <div class="input-group">
    <input class="form-control border no-shadow no-rounded" placeholder="Type your message here">
    <span class="input-group-btn">
      <button class="btn btn-success no-rounded" type="button">Send</button>
    </span>
  </div>
</div> -->
<!-- <li class="left clearfix">
  <span class="chat-img pull-left">
    <img src="https://bootdey.com/img/Content/user_3.jpg" alt="User Avatar">
  </span>
  <div class="chat-body clearfix">
    <div class="header">
      <strong class="primary-font">John Doe</strong>
      <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 12 mins ago</small>
    </div>
    <p>
      Lorem ipsum dolor sit amet, consectetur adipiscing elit.
    </p>
  </div>
</li> -->
