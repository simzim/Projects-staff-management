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
$title = "Personalas";
include 'includes/header.php';

$sql = 'SELECT employeeID, employeeFirstName, employeeLastName  FROM sz_employee';
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result)>0){
  while ($row = mysqli_fetch_assoc($result)){
    $person[]= $row;
  }
}
mysqli_close($conn);

?>

<body>
    <div class='main'>
        <div class="top-line">
            <p class="user-name"> <?php echo isset($message)? $message : '';  ?></p>
            <a class='link <?php echo isset($style)? $style : '';  ?>' href="<?php echo isset($link)? $link : '';  ?>">
                <?php  echo isset($btn)? $btn : '';   ?> </a>
        </div>
        <div class='width'>
            <h1>Personalas</h1>
            <?php

              if (!empty($person)){
                echo  '<table>';
                echo  '<tr>';
                echo  '<th> Eil.nr.</th><th>Vardas, Pavardė</th>';
                echo  '</tr>';
                $i=0;
                  foreach($person as $value){
                      $i++;
                    echo '<tr>';
                    echo '<td>'.$i.'.</td>';
                    echo '<td><a class="link" href="person.php/?id='.$value["employeeID"].'">'.$value["employeeFirstName"].' '.$value["employeeLastName"].'</a></td>';
                    echo '</tr>';
                  }
                echo  '</table>';
              }
              else{
                echo 'Drbuotoju nėra';
              }
      ?>
        </div>
    </div>
</body>