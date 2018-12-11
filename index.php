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
  <title>nate.gg | Official Site</title>
  <link rel="icon" href="images/natewords.png" type="image/png">
  <!--Scripts-->
  <link rel="stylesheet" href="styles\main.css" type="text/css"/>
  <link rel="stylesheet" href="node_modules\bootstrap\dist\css\bootstrap.min.css" type="text/css"/>
  <link rel="stylesheet" href="node_modules\@fortawesome\fontawesome-free\css\all.css" type="text/css"/>
  <script src="node_modules\jquery\dist\jquery.min.js"></script>
  <script src="node_modules\bootstrap\dist\js\bootstrap.min.js"></script>
  <script src="node_modules\typeit\dist\typeit.min.js"></script>
  <script src="node_modules\scrollreveal\dist\scrollreveal.min.js"></script>
</head>
<body>
<div id="main-wrapper">
  <!--Preloader-->
  <div class="preloader">
    <div class="loader">
    </div>
  </div>

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

  <!--Nav-->
  <div id="particles-js" class="header">
  <nav id="nav" class="navbar fixed-top navbar-height navbar-transparent justify-content-between">
  <a href=""><img style="max-height: 85px;" class="navbar-brand" src="images\natewords.png" alt="nate.gg"/></a>
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
            <a class="dropdown-item" href="cp/admin">Admin Panel</a>
            <?php } ?>
            <a class="dropdown-item" href="account/myaccount?user=<?php echo $_SESSION['userName'] ?>&valid=<?php echo $_SESSION['validUser'] ?>">Settings</a>
            <a class="dropdown-item logout" href="javascript:void(0);">Logout</a>
          </div>
        </div>
        <?php }
        ?>
        <i style="color:black;cursor:pointer;" class="menu-click fas fa-ellipsis-h pr-1"></i>
    </span>
  </nav>
  <div id="header-text">
    <h1 class="main-font font-weight-light"><?php if(isset($_SESSION['userName'])) { echo "Welcome back, ".$_SESSION['userName']; } else { ?><span style="cursor:pointer" onClick="ego()"><span class="welcome-left">Hello</span>, I'm <span class="welcome-right">Nathan.</span></span><?php } ?></h1>
    <p class="mt-4 header-text main-font"></p>
  </div>
  </div>

  <!--Content-->
  <div id="wrapper" class="container-fluid">

    <div class="t-outline row pt-5">
      <div class="flex-container-col col-12">
          <p class="main-font text-uppercase font-weight-light">
            Skillset
          </p>
          <h3 class="main-font font-weight-bold">
            <i class="fas fa-code"></i>
          </h3>
      </div>
    </div>

    <div class="row pt-1 pb-5 b-outline flex-wrap reveal">
      <div class="col-sm-12 col-md-6 col-lg-4 flex-container-col">
        <p class="font-weight-bold">HTML5/CSS3</p>
        <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam varius dignissim pretium. Nullam rhoncus semper lectus, in malesuada eros. Nulla rhoncus sit amet sem eget fermentum. Proin velit augue, fermentum non nulla sit amet, sagittis fermentum ex. Sed aliquam quam condimentum luctus porta. Ut et pellentesque orci. Quisque dignissim turpis posuere, congue nisl eget, varius sapien. Aenean at porttitor elit. Duis pretium congue eros, a mattis dolor semper quis. Suspendisse congue eu sapien eget faucibus. Duis id sapien risus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean tortor leo, rutrum eget erat nec, lobortis posuere dui. Aenean scelerisque, purus at fermentum dignissim, turpis nisi dignissim leo, a porta orci dolor ac justo. Integer quis imperdiet ipsum.</p>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-4 flex-container-col">
        <p class="font-weight-bold">JavaScript/JQuery</p>
        <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam varius dignissim pretium. Nullam rhoncus semper lectus, in malesuada eros. Nulla rhoncus sit amet sem eget fermentum. Proin velit augue, fermentum non nulla sit amet, sagittis fermentum ex. Sed aliquam quam condimentum luctus porta. Ut et pellentesque orci. Quisque dignissim turpis posuere, congue nisl eget, varius sapien. Aenean at porttitor elit. Duis pretium congue eros, a mattis dolor semper quis. Suspendisse congue eu sapien eget faucibus. Duis id sapien risus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean tortor leo, rutrum eget erat nec, lobortis posuere dui. Aenean scelerisque, purus at fermentum dignissim, turpis nisi dignissim leo, a porta orci dolor ac justo. Integer quis imperdiet ipsum.</p>
      </div>
      <div class="col-sm-12 col-md-12 col-lg-4 flex-container-col">
        <p class="font-weight-bold">PHP &#43; C#</p>
        <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam varius dignissim pretium. Nullam rhoncus semper lectus, in malesuada eros. Nulla rhoncus sit amet sem eget fermentum. Proin velit augue, fermentum non nulla sit amet, sagittis fermentum ex. Sed aliquam quam condimentum luctus porta. Ut et pellentesque orci. Quisque dignissim turpis posuere, congue nisl eget, varius sapien. Aenean at porttitor elit. Duis pretium congue eros, a mattis dolor semper quis. Suspendisse congue eu sapien eget faucibus. Duis id sapien risus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean tortor leo, rutrum eget erat nec, lobortis posuere dui. Aenean scelerisque, purus at fermentum dignissim, turpis nisi dignissim leo, a porta orci dolor ac justo. Integer quis imperdiet ipsum.</p>
      </div>
    </div>

    <div class="row pt-5">
      <div class="flex-container-col col-12">
          <p class="main-font text-uppercase font-weight-light">
            Skillset
          </p>
          <h3 class="main-font font-weight-bold">
            What I desire
          </h3>
      </div>
    </div>

    <div class="row pt-1 pb-5 b-outline reveal">
      <div class="col-sm-12 col-md-6 col-lg-4 flex-container-col">
        <p class="font-weight-bold">ASP.NET MVC &#43; Entity Framework</p>
        <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam varius dignissim pretium. Nullam rhoncus semper lectus, in malesuada eros. Nulla rhoncus sit amet sem eget fermentum. Proin velit augue, fermentum non nulla sit amet, sagittis fermentum ex. Sed aliquam quam condimentum luctus porta. Ut et pellentesque orci. Quisque dignissim turpis posuere, congue nisl eget, varius sapien. Aenean at porttitor elit. Duis pretium congue eros, a mattis dolor semper quis. Suspendisse congue eu sapien eget faucibus. Duis id sapien risus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean tortor leo, rutrum eget erat nec, lobortis posuere dui. Aenean scelerisque, purus at fermentum dignissim, turpis nisi dignissim leo, a porta orci dolor ac justo. Integer quis imperdiet ipsum.</p>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-4 flex-container-col">
        <p class="font-weight-bold">React</p>
        <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam varius dignissim pretium. Nullam rhoncus semper lectus, in malesuada eros. Nulla rhoncus sit amet sem eget fermentum. Proin velit augue, fermentum non nulla sit amet, sagittis fermentum ex. Sed aliquam quam condimentum luctus porta. Ut et pellentesque orci. Quisque dignissim turpis posuere, congue nisl eget, varius sapien. Aenean at porttitor elit. Duis pretium congue eros, a mattis dolor semper quis. Suspendisse congue eu sapien eget faucibus. Duis id sapien risus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean tortor leo, rutrum eget erat nec, lobortis posuere dui. Aenean scelerisque, purus at fermentum dignissim, turpis nisi dignissim leo, a porta orci dolor ac justo. Integer quis imperdiet ipsum.</p>
      </div>
      <div class="col-sm-12 col-md-12 col-lg-4 flex-container-col">
        <p class="font-weight-bold">C++</p>
        <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam varius dignissim pretium. Nullam rhoncus semper lectus, in malesuada eros. Nulla rhoncus sit amet sem eget fermentum. Proin velit augue, fermentum non nulla sit amet, sagittis fermentum ex. Sed aliquam quam condimentum luctus porta. Ut et pellentesque orci. Quisque dignissim turpis posuere, congue nisl eget, varius sapien. Aenean at porttitor elit. Duis pretium congue eros, a mattis dolor semper quis. Suspendisse congue eu sapien eget faucibus. Duis id sapien risus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean tortor leo, rutrum eget erat nec, lobortis posuere dui. Aenean scelerisque, purus at fermentum dignissim, turpis nisi dignissim leo, a porta orci dolor ac justo. Integer quis imperdiet ipsum.</p>
      </div>
    </div>
</div>
</div>

<script src="node_modules\particles.js\particles.js"></script>
<script src="node_modules\particles.js\app.js"></script>
<script src="scripts\functions.js"></script>
<script src="scripts\scripts.js"></script>
</body>
</html>
