<?php
  $hostname = "localhost";
  $username = "root";
  $password = "";
  $database = "chat_app";

  $conn = mysqli_connect($hostname, $username, $password, $database);
  if(!$conn){
    echo "Database connection error: " . mysqli_connect_error();
  }
?>
