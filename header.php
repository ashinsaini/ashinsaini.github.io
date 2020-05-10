<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>TIFF Database</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
   <script src = "/js/tablesorter.js"></script>

</head>
<body>
    <header>
     <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
         <a class="header-logo" href="https://www.tiff.net">
         <img src="logo-white.png" width="100" height= "70" alt="logo">    
         </a>
         <ul class= navbar-nav>
             <li>
             <a class="nav-link" href="index.php">Home</a></li>
             <li class= "nav-item">
             <a class="nav-link "href="https://www.tiff.net/support/">Support</a></li>
             <li class= "nav-item"><a class="nav-link" href="https://www.tiff.net/about">About Us</a></li>
             <li class="nav-item"><a class="nav-link" href="https://tiff.net/membership">Join</a></li>
         </ul>
         <?php 
          
    if (isset($_SESSION['userUid'])) {
        echo  '<form class = "navbar-collapse justify-content-end" action="includes/logout.inc.php" method="post">
             <button type="submit" name="logout-submit">Logout</button>
         </form>';
    }
    else{
         echo '<form class= "navbar-collapse justify-content-end" action="includes/login.inc.php" method = "post">
             <input type="text" name= "mailuid" placeholder="Username or email...">
             <input type="password" name= "pwd" placeholder="Enter Password">
             <button type="submit" name= "login-submit">Login</button>
            </form>
         <a class="nav-link" href="signup.php">Signup</a>';   
    }
         ?>      
           
         
     </nav>   
    </header>
</body>
</html>