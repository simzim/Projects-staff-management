<?php
session_start(); 
if (!isset($_SESSION['user_name']))
{
    header("Location: login.php");
    die();
}
$title = 'Dashboard';
include 'includes/header.php';
include 'includes/admin-menu.php';

    // DELETE FROM `sz_employee` WHERE `sz_employee`.`employeeID` = 4
 ?>  

    <body>  
        <div class='main'>
            <div class='top-line'>
                <p class="user-name">Prisijungęs vartotojas: <?php echo $_SESSION['user_name'] ;?></p>
                <a class='link btn-blue' href="logout.php">Atsijungti</a>
            </div>
            <div class='width flex'>
                <div class='block'>
                <a class='link big' href='admin-person.php'>Personalas</a>
                </div>
                <div class='block'>
                </div>
                <div class='block'>
                </div>
                <div class='block'>
                </div>            
            </div>

            
        </div>  
    </body>  
</html>  