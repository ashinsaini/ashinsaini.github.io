<?php 
//variables for  mysqli_connect (server,username,password,database)
$server = "127.0.0.1";
$username = "root";
$password = "";
$database = "test_mysql";

$succConnect = mysqli_connect($server,$username,$password,$database);

    if($succConnect){
        
        echo "connection was successful!";
    }else{
        echo "unsuccessful connection"; 
    }


$basicsqlquery = "select * from season_2018";
$query = mysqli_query($succConnect, $basicsqlquery);
//$fetch_array = mysqli_fetch_array($query, MYSQLI_NUM);
//foreach ($fetch_array as $result){
 
?>   



   
  
    
   