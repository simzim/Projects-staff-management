<?php
session_start(); 
if (!isset($_SESSION['user_name']))
{
    header("Location: login.php");
    die();
}
require 'includes/db.php';
$title = "Trinam vartotoja";
include 'includes/inner-header.php';
include 'includes/inner-admin-menu.php';
$employeeID = '';
if(!empty($_GET['id']) && is_numeric($_GET['id'])) {
  $employeeID = trim($_GET['id']);
}
if($employeeID!='') {
    $sql = "DELETE FROM sz_employee WHERE employeeID=$employeeID";
    if (mysqli_query($conn, $sql)) {
        $message = "Irašas ištrintas sėkmingai";
    } else {
        $message = "Klaida bandant pašalinti įrašą: " . mysqli_error($conn);
    }
}
mysqli_close($conn);
?>
<body>
    <div class="main">
        <div class='top-line'>
            <p class="user-name">Prisijungęs vartotojas: <?php echo $_SESSION['user_name'] ;?></p>
            <a class='link btn-blue' href="logout.php">Atsijungti</a>
        </div>
        <h3><?php echo isset($message)? $message : "";  ?></h3>
        <div class='width'>
        </div>
    </div>
</body>