<?php
require "header.php";

  $server = "127.0.0.1";
    $username = "root";
    $password = "";
    $database = "test_mysql";
    
    $connect = mysqli_connect($server,$username,$password,$database);
    
if (!$connect){
    
    die ("Connection failed: ".mysqli_connect_error());
}else{
    echo "connection successful";
}






?>


<main>
    <div class = "wrapper-main">
        <section class = "section-default"> 
        <?php
    
    if (isset($_SESSION['userUid'])) {
    
        include "search.php";
        
        
    }
    else{
         echo '<p class = "login-status">You are logged out</p>';   
    }
        ?>

        </section>
    </div>
</main>


