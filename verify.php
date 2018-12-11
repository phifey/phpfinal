<?php
session_start();
include_once('classes\user.php');
include_once('connectionLocal.php');
if((isset($_GET['code']) && !empty($_GET['code'])) && (isset($_GET['email']) && !empty($_GET['email'])))
{
  $email = $_GET['email'];
  $code = $_GET['code'];
  $table = "users_table";
  $verify = new User($conn, $table, '', '', '', '','', '','');

  if($verify->verify($email, $code))
  {
    header("Location: https://nate.gg/?verified=true");
  }
  else
  {
    echo "Something went wrong!";
  }
}
?>
