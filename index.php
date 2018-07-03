<?php
include'functions.php';
if(empty($_SESSION['login']))
    header("location:login.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content="Sistem pakar metode Certainty Factor (CF). Studi kasus: mendiagnosa penyakit pada jambu mente."/>
    <meta name="keywords" content="Sistem Pakar, Certainty Factor, CF, Penyakit Jambu Mente, Tugas Akhir, Skripsi, Jurnal, Source Code, PHP, MySQL, CSS, JavaScript, Bootstrap, jQuery"/>
    <meta name="author" content="Rahmat Sabilludin"/>
    <link rel="icon" href="favicon.ico"/>
    <link rel="canonical" href="http://<?=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']?>" />

    <title>Source Code Sistem Pakar Metode Certainty Factor</title>
    <link href="assets/css/slate-bootstrap.min.css" rel="stylesheet"/>
    <link href="assets/css/general.css" rel="stylesheet"/>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>           
  </head>
  <body>
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="?">SP-CF</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="?m=diagnosa"><span class="glyphicon glyphicon-pushpin"></span> Diagnosa</a></li>
            <li><a href="?m=gejala"><span class="glyphicon glyphicon-flash"></span> Gejala</a></li>
            <li><a href="?m=relasi"><span class="glyphicon glyphicon-star"></span> Relasi</a></li>
            <li><a href="?m=konsultasi"><span class="glyphicon glyphicon-stats"></span> Konsultasi</a></li>    
            <li><a href="?m=password"><span class="glyphicon glyphicon-lock"></span> Password</a></li>
            <li><a href="aksi.php?act=logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                     
          </ul>          
        </div>
    </nav>
    <div class="container">
    <?php
        if(file_exists($mod.'.php'))
            include $mod.'.php';
        else
            include 'home.php';
    ?>
    </div>
    <footer class="footer bg-primary">
      <div class="container">
        <p> <?=date('Y')?>  <span class="pull-right"></span></p>
      </div>
    </footer>
</html>