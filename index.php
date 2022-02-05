<?php 
session_start(); 
if (!isset($_SESSION['user_name']))
{
    $message = 'Neprisijungęs vartotojas';
    $link    = 'login.php';    
    $btn     = 'Prisijungti';
    $style   = 'btn';
    include 'includes/menu.php';
}
else{
    $message = 'Prisijungęs vartotojas: '.$_SESSION['user_name'];   
    $link    = 'logout.php';    
    $btn     = 'Atsijungti';
    $style   = 'btn-blue';
    include 'includes/admin-menu.php';
}

$title = "Pagrindinis";
include 'includes/header.php';

?>
<body>
    <div class="main">
        
        <div class="top-line">
            <p class="user-name"> <?php echo isset($message)? $message : '';  ?></p>
            <a class='link <?php echo isset($style)? $style : '';  ?>' href="<?php echo isset($link)? $link : '';  ?>"> <?php  echo isset($btn)? $btn : '';   ?>     </a>
        </div>

        <h1>Projektų valdymas</h1>
        <img class='image' src="img/project-plan.png">
    </div>
</body>
    

