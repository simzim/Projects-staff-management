<?php
$servername = 'localhost';
$username   = 'root';
$password   = '';
$database   = 'sz_project';
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
  die("Connection failed");
}