<?php
//initilize PHP
putenv("TZ=Asia/Kolkata");
if ( isset ( $_POST['submit'] ) ) //If submit is hit
{
//then connect as user
//change username and password to your mySQL username and password
mysql_connect("localhost","nightowl","thanks123");
//if you wish to connect to a local MySQL database the code is mysql_connect("localhost","root",""); until you set a username and password
//select which database you want to edit
mysql_select_db("nightowl")or die( "<p><span style=\"color: red;\">Unable to select database</span></p>");
//convert all the posts to variables:
$time = time(); $date = date('Y-m-d H:i:s',$time);
$tag = $_POST['tag'];
$res = mysql_query("select name from log_users where tag like '$tag'");
if(!($fields = mysql_fetch_assoc($res))){
  echo "User Not Found";
  exit();
}
$query = "select * from log where tag = '$tag' and out_time is NULL";
$flag = 0;
$result = mysql_query($query);
if($db_field = mysql_fetch_assoc($result)){
  $flag = 1;
  $dbdate = new DateTime($db_field['in_time']);
  $current = new DateTime(date('Y-m-d H:i:s',$time));
  $dbdate->add(new DateInterval('PT20S'));
  if($current < $dbdate){
      echo "repeat";
  }
  else{
    mysql_query("UPDATE `log` SET out_time = '$date' where tag = '$tag' AND out_time is NULL")
      or die( "<p><span style=\"color: red;\">Unable to select table</span></p>");
    echo "Welcome Back, ".$fields['name']."!";
  }
}
if($flag == 0){
  mysql_query("insert into log(tag,in_time,out_time) values('$tag','$date',NULL)");
  echo "Logged ".$fields['name']."!";
}

mysql_close();
}
?>
