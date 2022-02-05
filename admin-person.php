<?php
session_start(); 
if (!isset($_SESSION['user_name']))
{
    header("Location: login.php");
    die();
}
require 'includes/db.php';
$title = 'Dashboard';
include 'includes/header.php';
include 'includes/admin-menu.php';




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
    <div class="main">
        <div class='top-line'>
            <a class="icon-btn" href='insert-person.php'> <img src='img/addUser.png'>
                    <span class="tooltiptext">Pridėti darbuotoją</span></a>
            <p class="user-name">Prisijungęs vartotojas: <?php echo $_SESSION['user_name'] ;?></p>
            <a class='link btn-blue' href="logout.php">Atsijungti</a>
        </div>
        
        
        <div class='width'>
        <h4>Personalas <span class='yellow'>INSERT</span> / <span class='red'>DELETE</span> </h4>
            <?php
              if (!empty($person)){
                echo  '<table>';
                echo  '<tr>';
                echo  '<th> Eil.nr.</th><th>Vardas, Pavardė</th>';
                echo  '<th>Ištrinti</th>';
                echo  '</tr>';

                $i=0;
                  foreach($person as $value){
                      $i++;
                    echo '<tr>';
                    echo '<td>'.$i.'.</td>';
                    echo '<td><a class="link" href="person.php/?id='.$value["employeeID"].'">'.$value["employeeFirstName"].' '.$value["employeeLastName"].'</a></td>';
                    echo '<td><a class="icon-btn" onclick="return confirm(\'Ar Jus tikrai norite atleisti šį darbuotoją?\')" href="delete-person.php/?id='.$value["employeeID"].'"> <img src="img/deleteUser.png">
                    <span class="tooltiptext">Atleisti darbuotoją</span></a></td>';
                
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
