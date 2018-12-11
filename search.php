<?php
include_once("classes/dbconnect.php");
if(isset($_GET['query']) && !empty($_GET['query']))
{
  $searchResult = '';
  $db = new DatabaseConnect('root','','nategg','localhost');
  $query = $_GET['query'];
  $db->dbPrepare("SELECT * FROM products_table WHERE products_name LIKE '%$query%'");
  $exec = $db->executeQuery("selc");

  if($exec != '')
  {
      foreach($exec as $row)
      {
        $name = $row['products_name'];;
        $img = $row['products_imgUrl'];
        $type = $row['products_type'];
        $price = $row['products_price'];
        $altImg = $row['products_altImg'];

        $searchResult .= "<div class='$name card' style='width: 45%'>";
        if($altImg != '') {
          $searchResult .= "<div id='carouselExampleControls' class='carousel slide' data-ride='carousel'>
            <div class='carousel-inner'>
              <div class='carousel-item active'>
                <img class='d-block w-100' src='$img' alt='$name'>
              </div>
              <div class='carousel-item'>
                <img class='d-block w-100' src='$altImg' alt='$name'>
              </div>
              <a class='carousel-control-prev' href='#carouselExampleControls' role='button' data-slide='prev'>
                <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                <span class='sr-only'>Previous</span>
              </a>
              <a class='carousel-control-next' href='#carouselExampleControls' role='button' data-slide='next'>
                <span class='carousel-control-next-icon' aria-hidden='true'></span>
                <span class='sr-only'>Next</span>
              </a>
            </div>";
        } else
        {
          $searchResult .= "
          <img class='card-img-top' style='width: 100%' height='auto' src='$img' alt='$name'>";
        }
        $searchResult .= "
          <div class='card-body'>
            <h5 class='card-title'>$name</h5>
            <p class='card-text'>$type | $$price</p>
        </div>
        ";
        $searchResult .= '</div>';
      }
    $db->dbCloseConn();
    echo $searchResult;
  }
  else
  {
    echo "Data not found";
  }
}

if(isset($_GET['show']) && !empty($_GET['show']))
{
  $searchResult = '';
  $db = new DatabaseConnect('root','','nategg','localhost');
  $query = $_GET['show'];
  $db->dbPrepare("SELECT * FROM products_table");
  $exec = $db->executeQuery("selc");

  if($exec != '')
  {
      foreach($exec as $row)
      {
        $name = $row['products_name'];;
        $img = $row['products_imgUrl'];
        $type = $row['products_type'];
        $price = $row['products_price'];
        $altImg = $row['products_altImg'];

        $searchResult .= "<div class='$name card' style='width: 45%'>";
        if($altImg != '') {
          $searchResult .= "<div id='carouselExampleControls' class='carousel slide' data-ride='carousel'>
            <div class='carousel-inner'>
              <div class='carousel-item active'>
                <img class='d-block w-100' src='$img' alt='$name'>
              </div>
              <div class='carousel-item'>
                <img class='d-block w-100' src='$altImg' alt='$name'>
              </div>
              <a class='carousel-control-prev' href='#carouselExampleControls' role='button' data-slide='prev'>
                <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                <span class='sr-only'>Previous</span>
              </a>
              <a class='carousel-control-next' href='#carouselExampleControls' role='button' data-slide='next'>
                <span class='carousel-control-next-icon' aria-hidden='true'></span>
                <span class='sr-only'>Next</span>
              </a>
            </div>";
        } else
        {
          $searchResult .= "
          <img class='card-img-top' style='width: 100%' height='auto' src='$img' alt='$name'>";
        }
        $searchResult .= "
          <div class='card-body'>
            <h5 class='card-title'>$name</h5>
            <p class='card-text'>$type | $$price</p>
        </div>
        ";
        $searchResult .= '</div>';
      }
    $db->dbCloseConn();
    echo $searchResult;
  }
  else
  {
    echo "Data not found";
  }
}

if(isset($_GET['price']) && !empty($_GET['price']) && $_GET['price'] === "desc")
{
  $searchResult = '';
  $db = new DatabaseConnect('root','','nategg','localhost');
  $query = $_GET['price'];
  $db->dbPrepare("SELECT * FROM products_table ORDER BY products_price DESC");
  $exec = $db->executeQuery("selc");

  if($exec != '')
  {
      foreach($exec as $row)
      {
        $name = $row['products_name'];;
        $img = $row['products_imgUrl'];
        $type = $row['products_type'];
        $price = $row['products_price'];
        $altImg = $row['products_altImg'];

        $searchResult .= "<div class='$name card' style='width: 45%'>";
        if($altImg != '') {
          $searchResult .= "<div id='carouselExampleControls' class='carousel slide' data-ride='carousel'>
            <div class='carousel-inner'>
              <div class='carousel-item active'>
                <img class='d-block w-100' src='$img' alt='$name'>
              </div>
              <div class='carousel-item'>
                <img class='d-block w-100' src='$altImg' alt='$name'>
              </div>
              <a class='carousel-control-prev' href='#carouselExampleControls' role='button' data-slide='prev'>
                <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                <span class='sr-only'>Previous</span>
              </a>
              <a class='carousel-control-next' href='#carouselExampleControls' role='button' data-slide='next'>
                <span class='carousel-control-next-icon' aria-hidden='true'></span>
                <span class='sr-only'>Next</span>
              </a>
            </div>";
        } else
        {
          $searchResult .= "
          <img class='card-img-top' style='width: 100%' height='auto' src='$img' alt='$name'>";
        }
        $searchResult .= "
          <div class='card-body'>
            <h5 class='card-title'>$name</h5>
            <p class='card-text'>$type | $$price</p>
        </div>
        ";
        $searchResult .= '</div>';
      }
    $db->dbCloseConn();
    echo $searchResult;
  }
  else
  {
    echo "Data not found";
  }
}
?>
