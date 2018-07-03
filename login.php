<?php include 'functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW"/>
    <title>LOGIN</title>
    <link href="../assets/css/slate-bootstrap.min.css" rel="stylesheet"/>
    <link href="../assets/css/signin.css" rel="stylesheet"/>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>     
  </head>

  <body>
    <div class="container">
      <center><form class="form-signin" action="?act=login" method="post">        
        <center><h2 class="form-signin-heading">Silahkan masuk</h2></center>
        <?php     if($_POST) include 'aksi.php';  ?>
        <label for="inputEmail" class="sr-only">Usernames</label>
        <input type="text" id="inputEmail" class="form-control" placeholder="Username" name="user" autofocus />
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="pass" />        
        <button class="btn btn-lg btn-primary btn-block" type="submit">Masuk</button>        
      </form></center>      
    </div>
</html>
