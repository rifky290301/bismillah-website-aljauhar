<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('title')</title>
  <meta content="" name="description">

  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href={{ asset("assets/img/favicon.png")}} rel="icon">
  <link href={{ asset("assets/img/apple-touch-icon.png")}} rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,60,500i,600,600i,700,700i"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href={{ asset("assets/vendor/bootstrap/css/bootstrap.min.css")}} rel="stylesheet">
  <link href={{ asset("assets/vendor/bootstrap-icons/bootstrap-icons.css")}} rel="stylesheet">
  <link href={{ asset("assets/vendor/aos/aos.css")}} rel="stylesheet">
  <link href={{ asset("assets/vendor/remixicon/remixicon.css")}} rel="stylesheet">
  <link href={{ asset("assets/vendor/swiper/swiper-bundle.min.css")}} rel="stylesheet">
  <link href={{ asset("assets/vendor/glightbox/css/glightbox.min.css")}} rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: FlexStart - v1.4.0
  * Template URL: https://bootstrapmade.com/flexstart-bootstrap-startup-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logoweb.png" alt="">
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link active" href="#hero">Berita</a></li>
          <li><a class="nav-link" href="#tentang">Artikel</a></li>
          <li><a class="nav-link" href="#faq">Biografi</a></li>
          <li><a class="nav-link " href="#">Daftar</a></li>
          <li><a class="button-masuk " href="/login">Masuk</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  @yield('content')
  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-5 col-md-12 footer-info">
            <a href="index.html" class="logo d-flex align-items-center">
              <img src="assets/img/logoweb.png" alt="">
              {{-- <span>Al-Jauhar</span> --}}
            </a>
            <p><strong>Visi & Misi</strong> Unggul dalam Prestasi dan
              Akhlaqul
              Karimah
              Serta Berpijak pada
              Ajaran Ahlussunah Wal Jamaah Annahdiyah</p>
            <div class="social-links mt-3">
              <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram bx bxl-instagram"></i></a>
              <a href="#" class="linkedin"><i class="bi bi-linkedin bx bxl-linkedin"></i></a>
            </div>
          </div>

        

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright 2021<strong><span>AL-JAUHAR</span></strong>. All Rights Reserved
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src={{ asset("assets/vendor/bootstrap/js/bootstrap.bundle.js")}}></script>
  <script src={{ asset("assets/vendor/aos/aos.js")}}></script>
  <script src={{ asset("assets/vendor/php-email-form/validate.js")}}></script>
  <script src={{ asset("assets/vendor/swiper/swiper-bundle.min.js")}}></script>
  <script src={{ asset("assets/vendor/purecounter/purecounter.js")}}></script>
  <script src={{ asset("assets/vendor/isotope-layout/isotope.pkgd.min.js")}}></script>
  <script src={{ asset("assets/vendor/glightbox/js/glightbox.min.js")}}></script>

  <!-- Template Main JS File -->
  <script src={{ asset("assets/js/main.js") }}></script>

</body>

</html>