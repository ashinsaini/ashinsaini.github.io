<?php

$servername="localhost";
$username="root";
$dBPassword="";
$database="logindb";

$conn = mysqli_connect($servername,$username,$dBPassword,$database);


if (!$conn) {
    die("Connection failed: ".mysqli_connect_error());
}