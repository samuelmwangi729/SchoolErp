<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{config('app.name')}}</title>
	<link rel="icon" href="img/logo.png" type="image/png">

  <link rel="stylesheet" href="vendors/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="vendors/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="vendors/themify-icons/themify-icons.css">
  <link rel="stylesheet" href="vendors/linericon/style.css">
  <link rel="stylesheet" href="vendors/owl-carousel/owl.theme.default.min.css">
  <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css">

  <link rel="stylesheet" href="css/style.css">
</head>
<body style="overflow:hidden">
  <!--================Header Menu Area =================-->
  <header class="header_area">
    <div class="main_menu">
      <nav class="navbar navbar-expand-sm navbar-light">
        <div class="container box_1620">
          <!-- Brand and toggle get grouped for better mobile display -->
          <a class="navbar-brand logo_h" href="/"><img src="img/logo.png" alt="{{config('app.name')}}" width="100px" height="30px"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
            <ul class="nav navbar-nav menu_nav justify-content-end">
              <li class="nav-item"><a class="nav-link" href="contact.html">Contact Us</a></li>
            @if(Auth::check())
            <li class="nav-item"><a class="nav-link" href="/home">My Account</a></li>
            @else
            <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
            @endif
            </ul>

            <ul class="navbar-right">
              <li class="nav-item">
               @if(auth::check())
               @else
               <button class="button button-header bg" onclick="window.open('/login','_parent');">Login</button>
               @endif
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <section class="hero-banner" style="height:720px">
    <div class="container">
      <div class="row">
        <div class="col-lg-7 col-sm-12 col-xs-12">
          <div class="hero-banner__img">
            <img class="img-fluid" src="img/banner/hero-banner.png" alt="">
          </div>
        </div>
        <div class="col-lg-5  col-sm-5 col-xs-5">
          <div class="hero-banner__content">
            <h1>Advanced software made simple</h1>
            <p>Management Is the Heart of each and every Institution. With  {{config('app.name')}} School System, we guarantee smooth running of the Institution.Give it a try</p>
            <a class="button bg" href="#">Get Started</a><br><br>
            &copy;2020 SmartSoft International All Rights Reserved
          </div>
        </div>
      </div>
    </div>
  </section>
  <script src="vendors/jquery/jquery-3.2.1.min.js"></script>
  <script src="vendors/bootstrap/bootstrap.bundle.min.js"></script>
  <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
  <script src="js/jquery.ajaxchimp.min.js"></script>
  <script src="js/mail-script.js"></script>
  <script src="js/main.js"></script>
 </body>
</html>
