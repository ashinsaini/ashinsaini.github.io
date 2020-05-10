<?php


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