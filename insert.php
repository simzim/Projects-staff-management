<?php
session_start();
if (!isset($_SESSION['user_name'])) {
  header("Location: login.php");
  die();
}
require 'includes/db.php';



$frstName = mysqli_real_escape_string($conn, $_POST['fname']);
$lastName = mysqli_real_escape_string($conn, $_POST['lname']);
$email    = mysqli_real_escape_string($conn, $_POST['email']);
$phone    = mysqli_real_escape_string($conn, $_POST['phone']);
$teamID   = mysqli_real_escape_string($conn, $_POST['team']);
$roleID   = mysqli_real_escape_string($conn, $_POST['role']);

$sql = "INSERT INTO sz_employee (employeeFirstName, employeeLastName, employeeEmail, employeePhone) 
    VALUES ( '$frstName', '$lastName', '$email', '$phone');
    INSERT INTO sz_team_member ( teamID, employeeID, roleID) 
    VALUES ('$teamID', (SELECT MAX(employeeID) FROM sz_employee), '$roleID'); ";


$result = mysqli_query($conn, $sql);

mysqli_close($conn);
// header('Location: admin-person.php?insert=success');
