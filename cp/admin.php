<?php
session_start();

if((isset($_SESSION['userName']) && !empty($_SESSION['userName']) && $_SESSION['userName'] === "wdv341") && (isset($_SESSION['validUser'])))
{
  include '../connectionLocal.php';
  include '../classes/user.php';
  $table = "products_table";
  $newArray = array(
    "0" => "products_id",
    "2" => "products_type",
    "3" => "products_imgUrl",
    "4" => "products_name",
    "5" => "products_price",
    "6" => "products_altImg"
  );
  $admin = new Admin($conn, $table, $newArray);
?>
<!doctype html>
<head>
  <meta charset="UTF-8">
  <meta name="description" content="Free Web tutorials">
  <meta name="keywords" content="HTML,CSS,XML,JavaScript">
  <meta name="author" content="John Doe">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>nate.gg | Admin Panel</title>
    <link rel="icon" href="../images/natewords.png" type="image/png">
  <!--Scripts-->
  <link rel="stylesheet" href="../styles/admin.css" type="text/css"/>
  <link rel="stylesheet" href="../styles/main.css" type="text/css"/>
  <link rel="stylesheet" href="..\node_modules\bootstrap\dist\css\bootstrap.min.css" type="text/css"/>
  <link rel="stylesheet" href="..\node_modules\@fortawesome\fontawesome-free\css\all.css" type="text/css"/>
  <script src="..\node_modules\jquery\dist\jquery.min.js"></script>
  <script src="..\node_modules\bootstrap\dist\js\bootstrap.min.js"></script>
  <script src="..\node_modules\typeit\dist\typeit.min.js"></script>
</head>
<body>

  <!--Dynamic Modals-->
  <div id="modals">
  </div>

  <!--Search Overlay-->
  <div class="search-container">
    <div class="search-hidden">
      <input class="main-font text-uppercase font-weight-light search-input" placeholder="TYPE TO SEARCH"/>
      <p style="color:white" class="json-response"></p>
      <i style="color: white;cursor: pointer;" class="mt-2 search-close far fa-window-close fa-2x"></i>
      <div class="flex-container wrap pt-5 search-items"></div>
    </div>
  </div>

  <!--Navigation Overlay-->
  <div class="navbar-hidden">
    <ul>
      <li id="type-it-home" class="list-item type-it-home main-font text-uppercase"></li>
      <li id="type-it-register" class="list-item type-it-register main-font text-uppercase"></li>
      <li id="type-it-login" class="list-item type-it-login main-font text-uppercase"></li>
      <li id="type-it-contact" class="list-item type-it-contact main-font text-uppercase"></li>
      <i style="color: white;cursor: pointer;" class="navbar-close far fa-window-close fa-2x"></i>
    </ul>
  </div>

<nav id="nav" class="navbar fixed-top navbar-transparent justify-content-between">
<a href="../"><img style="max-height: 85px;" class="navbar-brand" src="..\images\natewords.png" alt="nate.gg"/></a>
  <span class="navbar-text pr-2">
      <span style="color:black" class="search-click mr-3">Search</span>
      <?php if(isset($_SESSION['validUser']) && isset($_SESSION['userName'])) {
      ?>
      <div style="z-index: 20000;" class="mr-3 btn-group">
          <i data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:black;cursor:pointer" class="fas fa-cog pr-1"></i>
        <div style="z-index: 20000;" class="dropdown-menu dropdown-menu-right">
          <h6 class="dropdown-header">Account</h6>
          <?php if(isset($_SESSION['validUser']) && $_SESSION['userName'] === "wdv341") {
          ?>
          <a class="dropdown-item" href="">Admin Panel</a>
          <?php } ?>
          <a class="dropdown-item" href="../account/myaccount?user=<?php echo $_SESSION['userName'] ?>&valid=<?php echo $_SESSION['validUser'] ?>">Settings</a>
          <a class="dropdown-item logout" href="javascript:void(0);">Logout</a>
        </div>
      </div>
      <?php }
      ?>
      <i style="color:black;cursor:pointer;" class="menu-click fas fa-ellipsis-h pr-1"></i>
  </span>
</nav>

<div class="container-fluid">

<div id="table" class="row">
  <div class="flex-container-col col-12">
    <button id="display-table" class="mb-3 btn btn-outline-dark">Display Users Table</button>
      <?php $admin->fetchTable(); ?>
  </div>
</div>

<div id="sql-table" class="row">
  <div class="flex-container col-12">
    <form id="sql-form" action="sql.php" method="post">
      <div class="flex-container-col">
          <h5 class="main-font">Products Table Form</h5>
          <p class="main-font font-sm">Update / Delete / Insert</p><br/>
          <input type="text" name="products_type" id="products_type" placeholder="Product Type"/><br/>
          <input type="text" name="products_imgUrl" id="products_imgUrl" placeholder="Product Image"/><br/>
          <input type="text" name="products_name" id="products_name" placeholder="Product Name"/><br/>
          <input type="text" name="products_price" id="products_price" placeholder="Product Price"/><br/>
          <input type="text" name="products_altImg" id="products_altImg" placeholder="Product Alt Image"/><br/>
          <p class="main-font font-sm>">WHERE</p><br/>
          <input type="text" name="products_id" id="products_id" placeholder="Product Id = #"/><br/>
      </div>
      <div class="flex-container">
        <div class="flex-container-col mx-2">
          <label for="update">Update</label>
          <input type="radio" name="sqlQuery" id="update" value="Update"/>
        </div>
        <div class="flex-container-col mx-2">
          <label for="insert">Insert</label>
          <input type="radio" name="sqlQuery" id="insert" value="Insert"/>
        </div>
        <div class="flex-container-col mx-2">
          <label for="delete">Delete</label>
          <input type="radio" name="sqlQuery" id="delete" value="Delete"/>
        </div>
      </div>
      <div class="flex-container mt-2">
        <input type="button" onclick="sql()" class="btn btn-outline-dark" value="Submit"/>
      </div>
    </form>
  </div>
</div>

<div class="flex-container">
  <p class="response"></p>
</div>

</div>

<script src="..\scripts\functions.js"></script>
<script src="..\scripts\scripts.js"></script>
</body>
<?php }
else {
  echo "Sorry, you don't have access to see this page!";
} ?>
