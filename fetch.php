<?php
session_start();
require_once('classes\validation.php');
require_once('classes\user.php');
require_once('connectionLocal.php');
require_once('classes\mailer.php');
require_once('classes\dbconnect.php');
require_once('classes\php_lib_googl_auth\GoogleAuthenticator.php');

if(isset($_POST['contact']))
{
  $valid = false;
  $data = array();
  $email = $_POST['email'];
  $comment = $_POST['comment'];
  $array = array($email, $comment);
  $validate = new Validation();

  if($validate->isNotEmpty($array))
  {
    $valid = true;
    $data['success'] = "true";
  }
  else
  {
    $string = implode(',',$validate->getErrors());
    $data['error'] = $string." fields cannot be blank!";
  }

  if($valid)
  {
    $sendMail = new Mail();
    $sendMail->setReceiver("me@nate.gg");
    $sendMail->setSubject("You've been contacted by someone!");
    $sendMail->setMessage("Email: ".$email." Message: ".$comment);
    if($sendMail->emailPerson())
    {
      $data['mailed'] = "true";
    }
    else
    {
      $data['error'] = "Email did not send, unexpected error!";
    }
  }
}

if(isset($_POST['register']))
{
  $valid = false;
  $data = array();
  $success = array();
  $error = array();
  $name = $_POST['fullname'];
  $pass = $_POST['password'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $array = array($name, $pass, $email, $username);
  $validate = new Validation();

  if(isset($_SESSION['validUser']))
  {
    $data['error'] = "You can't register silly! Logout to make a new account";
    echo json_encode($data);
  }
  else {
    if($validate->isNotEmpty($array))
    {
      if($validate->mainValidation($email,FILTER_VALIDATE_EMAIL))
      {
		    $valid = true;
        $data['success'] = "No issues with the email";
      }
      else {
        $string = implode(',',$validate->getErrors());
        $data['error'] = $string." is not a valid email!";
      }
    } else {
        $string = implode(',',$validate->getErrors());
        $data['error'] = $string." fields cannot be blank!";
      }

      if($valid)
      {
        $code= substr(md5(mt_rand()),0,50);
        $table = "users_table";
        $userRegister = new User($conn,$table,$name,$pass,$phone,$email,$username,$code);
        if($userRegister->register())
        {
          $data['registered'] = "true";

          $sendMail = new Mail();
          $dir = dirname(__FILE__);
          $dir.= '\verify.php?code='.$code.'&id=1';
          $sendMail->setMailer("me@nate.gg");
          $sendMail->setReceiver($email);
          $sendMail->setSubject("Thank you for registering");
          $sendMail->setMessage('

          Thanks for signing up! <br/>
          Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below. <br/>

          ------------------------ <br/>
          Username: '.$name.' <br/>
          Password: '.$pass.' <br/>
          ------------------------ <br/>

          Please click this link to verify your email: <br/>
          https://nate.gg/verify?code='.$code.'&email='.$email.' <br />
          Best Regards, <br />
          --  <br />
          <br />
          NATEGG - https://www.nate.gg
          ');

          if($sendMail->emailPerson())
          {
            $data['mailed'] = $email;
          }
        }
        else {
          $data['success'] = "";
          $data['error'] = $userRegister->getMsg();
        }
      }
  }
}

if(isset($_POST['login']))
{
  $valid = false;
  $data = array();
  $success = array();
  $error = array();
  $username = $_POST['username'];
  $pass = $_POST['password'];
  $code = $_POST['2fa'];
  $array = array($username, $pass);
  $validate = new Validation();

  if(isset($_SESSION['validUser']))
  {
    $data['error'] = "You can't login again silly! Logout first!";
    echo json_encode($data);
  }
  else {
    if($validate->isNotEmpty($array))
    {
      $data['success'] = "Nothing is empty";
      $valid = true;
    } else {
      $string = implode(',',$validate->getErrors());
      $data['error'] = $string." fields cannot be blank!";
    }

    if($valid)
    {
      $table = "users_table";
      $userLogin = new User($conn,$table,'',$pass,'','',$username);

      if($userLogin->login("true"))
      {
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
          if(isset($code) && !empty($code))
          {
            $auth = new GoogleAuthenticator();
            $checkResult = $auth->checkCode($str, $code);
            if($checkResult)
            {
              $data['loggedIn'] = "true";
              $data['valid2FA'] = "true";
              $_SESSION['validUser'] = "true";
              $_SESSION['userName'] = $username;
              $userLogin->hashPassword($password);
              $_SESSION['password'] = $userLogin->getHash();
              $_SESSION['email'] = $userLogin->getEmail();
              echo json_encode($data);
            }
            else
            {
              $data['success'] = "";
              $data['error'] = "Invalid google authenticator code, try again";
            }
          } else {
            $data['success'] = "Your credentials are valid, but you have 2FA enabled, please enter the code above and then re-submit";
            $data['enter2FA'] = "true";
          }
        } else {
          $data['loggedIn'] = "true";
          $_SESSION['validUser'] = "true";
          $_SESSION['userName'] = $username;
          $userLogin->hashPassword($password);
          $_SESSION['password'] = $userLogin->getHash();
          $_SESSION['email'] = $userLogin->getEmail();
          echo json_encode($data);
        }
      }
      else {
        $data['success'] = "";
        $data['error'] = "Invalid username or password, try again";
      }
    }
  }
}

if(isset($_GET['logout']))
{
  $userLogout = new User($conn, $table, '', '', '', '', '');
  if($_SESSION['validUser'])
  {
    $userLogout->logoutUser();
  }
}

if(empty($_SESSION['validUser']))
{
  if(isset($_POST['requestpassword']))
  {
    $data = array();
    $email = $_POST['email'];
    $table = "users_table";
    $checkEmail = new User($conn, $table);
    if($checkEmail->requestPassword($email))
    {
      $data['success'] = "true";

      $sendMail = new Mail();
      $sendMail->setMailer("me@nate.gg");
      $sendMail->setReceiver($email);
      $sendMail->setSubject("Password requested");
      $sendMail->setMessage('
      Please click this link to reset your password: <br/>
      https://nate.gg/resetpassword?email='.$email.' <br />
      Best Regards, <br />
      --  <br />
      <br />
      NATEGG - https://www.nate.gg
      ');

    if($sendMail->emailPerson())
    {
      $data['mailed'] = $email;
    } else {
      $data['error'] = "Email failed to send, please request password again";
    }

    }else {
      $data['error'] = $checkEmail->getMsg();
    }
  }
  echo json_encode($data);
}
?>
