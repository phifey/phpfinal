<?php
session_start();
?>
<!doctype html>
<head>
  <meta charset="UTF-8">
  <meta name="description" content="Free Web tutorials">
  <meta name="keywords" content="HTML,CSS,XML,JavaScript">
  <meta name="author" content="John Doe">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>nate.gg | Lookbook</title>
    <link rel="icon" href="../images/natewords.png" type="image/png">
  <!--Scripts-->
  <link rel="stylesheet" href="../styles/main.css" type="text/css"/>
  <link rel="stylesheet" href="../styles/lookbook.css" type="text/css"/>
  <link rel="stylesheet" href="..\node_modules\bootstrap\dist\css\bootstrap.min.css" type="text/css"/>
  <link rel="stylesheet" href="..\node_modules\@fortawesome\fontawesome-free\css\all.css" type="text/css"/>
  <script src="..\node_modules\jquery\dist\jquery.min.js"></script>
  <script src="..\node_modules\bootstrap\dist\js\bootstrap.min.js"></script>
  <script src="..\node_modules\typeit\dist\typeit.min.js"></script>
  <script src="..\scripts\lookbook.js"></script>
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
        <?php if(isset($_SESSION['validUser']) && isset($_SESSION['userName'])) {
        ?>
        <div style="z-index: 20000;" class="mr-3 btn-group">
            <i data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:black;cursor:pointer" class="fas fa-cog pr-1"></i>
          <div style="z-index: 20000;" class="dropdown-menu dropdown-menu-right">
            <h6 class="dropdown-header">Account</h6>
            <?php if(isset($_SESSION['validUser']) && $_SESSION['userName'] === "wdv341") {
            ?>
            <a class="dropdown-item" href="../cp/admin">Admin Panel</a>
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

<div class="flex-container main-search row">
  <input class="main-font text-uppercase font-weight-light search-input-main" placeholder="TYPE TO SEARCH"/>
</div>

<div class="row">
  <div class="flex-container col-12 mt-3">
      <button id="shop-show-all" class="shop-button">Show All</button>
      <button id="shop-sort-by-price" class="shop-button">Sort by Price</button>
  </div>
</div>

<div class="row">
  <div class="wrap flex-container-row-left col-12">
    <div style="width: 100%" class="flex-container" id="cardArea">
    </div>
  </div>
</div>

</div>

<script src="..\scripts\functions.js"></script>
<script src="..\scripts\scripts.js"></script>
</body>
</html>
