<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/introphp/final/classes/dbconnect.php");
include_once($_SERVER['DOCUMENT_ROOT']."/introphp/final/classes/php_lib_googl_auth/GoogleAuthenticator.php");

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit']))
{
  $code = $_POST['code'];
  $secret = $_SESSION['auth_secret'];
  $username = $_SESSION['userName'];

  $auth = new GoogleAuthenticator();
  $checkResult = $auth->checkCode($secret, $code);
  
  if($checkResult)
  {
    $enter2FA = new DatabaseConnect('root','','nategg','localhost');
    $enter2FA->dbPrepare("UPDATE users_table SET user_two_factor = '$secret' WHERE user_username = '$username'");
    $enter2FA->executeQuery("ins");
    header("Location: myaccount.php?2fa=enabled");
  } else
  {
    echo "oof";
  }

}

if(isset($_SESSION['userName']) && !empty($_SESSION['userName']))
{
  $authUser = $_SESSION['userName'];

  $auth = new GoogleAuthenticator();
  if(!isset($_SESSION['auth_secret']))
  {
    $secret = $auth->generateSecret();
    $_SESSION['auth_secret'] = $secret;
  }

  $qrCode = $auth->getURL($authUser,$_SERVER['HTTP_HOST'],$_SESSION['auth_secret']);
}
?>
<!doctype html>
<head>
</head>
<body>
  <a href="<?php echo $qrCode ?>"><img src="<?php echo $qrCode ?>" alt="GoogleAuth"></a>
  <form method="post" action="auth.php">
    <input type="text" name="code" id="code" placeholder="Enter 6 digit code"/>
    <input type="submit" id="submit" name="submit" value="Verify"/>
  </form>
</body>
</html>
