<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/introphp/final/classes/dbconnect.php");
include_once($_SERVER['DOCUMENT_ROOT']."/introphp/final/classes/php_lib_googl_auth/GoogleAuthenticator.php");

if(isset($_SESSION['userName']) && !empty($_SESSION['userName']))
{
  $username = $_SESSION['userName'];
  $is2FA = new DatabaseConnect('root','','nategg','localhost');
  $is2FA->dbPrepare("SELECT user_two_factor FROM users_table WHERE user_username = '$username'");
  $fetch = $is2FA->executeQuery("selc");

  $str = '';
  foreach($fetch as $key => $row)
  {
    $str.= $row['user_two_factor'];
  }

  if($str != '')
  {
    echo "2FA already enabled!";
  }
  else {
    echo "<a style='color:black' href='auth.php'>Enable 2FA</a>";
  }
}
?>
