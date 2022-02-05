<?php
session_start(); 
if (!isset($_SESSION['user_name']))
{
    include 'includes/menu.php';
    $message = 'Neprisijungęs vartotojas';
    $link    = 'login.php';    
    $btn     = 'Prisijungti';
    $style   = 'btn';
}
else{
    include 'includes/admin-menu.php';
    $message = 'Prisijungęs vartotojas: '.$_SESSION['user_name'];   
    $link    = 'logout.php';    
    $btn     = 'Atsijungti';
    $style   = 'btn-blue';
}
require 'includes/db.php';
$title = "Projektai";
include 'includes/header.php';


$sql = 'SELECT 	categoryID, categoryName  FROM sz_category';
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result)>0){
  while ($row = mysqli_fetch_assoc($result)){
    $category[]= $row;
  }
}
mysqli_close($conn);
?>

<body>
    <div class='main'>
        <div class="top-line">
            <p class="user-name"> <?php echo isset($message)? $message : '';  ?></p>
            <a class='link <?php echo isset($style)? $style : '';  ?>' href="<?php echo isset($link)? $link : '';  ?>"> <?php  echo isset($btn)? $btn : '';   ?>     </a>
        </div>
        <div class='width'>
          <h1>Projektų kategorijos</h1>
          <?php

            if (!empty($category)){
              echo  '<table>';
              echo  '<tr>';
              echo  '<th> Eil.nr.</th><th>Kategorijos pavadinimas</th>';
              echo  '</tr>';
              $i=0;
                foreach($category as $value){
                  $i++;
                  echo '<tr>';
                  echo '<td>'.$i.'.</td>';
                  echo '<td><a class="link" href="category.php/?id='.$value['categoryID'].'">'.$value["categoryName"].'</a></td>';
                  echo '</tr>';
                }
              echo  '</table>';
            }
            else{
              echo 'Projektų kategorijų nėra';
            }
            ?>
      </div>
    </div>
</body>