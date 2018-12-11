<?php
session_start();
require_once("../classes/dbconnect.php");
if(isset($_SESSION['userName']) && !empty($_SESSION['userName']) && $_SESSION['userName'] === "wdv341" && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sqlQuery']))
{
  $newConn = new DatabaseConnect('root','','nategg','localhost');

  $params = array();

  if(isset($_POST['products_id']) && !empty($_POST['products_id']))
  {
    $params = array(
      ":type" => $_POST['products_type'],
      ":imgUrl" => $_POST['products_imgUrl'],
      ":name" => $_POST['products_name'],
      ":price" => $_POST['products_price'],
      ":altImgUrl" => $_POST['products_altImg'],
      ":id" => $_POST['products_id']
    );
  } else {
    $params = array(
      ":type" => $_POST['products_type'],
      ":imgUrl" => $_POST['products_imgUrl'],
      ":name" => $_POST['products_name'],
      ":price" => $_POST['products_price'],
      ":altImgUrl" => $_POST['products_altImg'],
    );
  }

  $query = $_POST['sqlQuery'];
  $queryCap = strtoupper($query);

  if($query == "Insert")
  {
    print_r($params);
    $newConn->dbPrepare("$queryCap INTO products_table (products_type, products_imgUrl, products_name, products_price, products_altImg) VALUES (:type,:imgUrl,:name,:price,:altImgUrl)");
    $newConn->bindParams($params);
    $newConn->executeQuery("ins");
    echo "Insert was successfully done";
  }

  if($query == "Delete")
  {
    $params = array (
      ":id" => $_POST['products_id']
    );

    $newConn->dbPrepare("$queryCap FROM products_table WHERE products_id = :id");
    $newConn->bindParams($params);
    $newConn->executeQuery("del");
    echo "Delete was successfully done";
  }

  if($query == "Update")
  {
    $newConn->dbPrepare("$queryCap products_table SET products_type = :type, products_imgUrl = :imgUrl, products_name = :name, products_price = :price, products_altImg = :altImgUrl WHERE products_id = :id");
    $newConn->bindParams($params);
    $newConn->executeQuery("upd");
    echo "Update was successfully done";
  }
} else
{
  echo "Please select one type of query";
}
 ?>
