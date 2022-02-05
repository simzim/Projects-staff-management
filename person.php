<?php
session_start(); 
if (!isset($_SESSION['user_name']))
{
    include 'includes/inner-menu.php';
    $message = 'Neprisijungęs vartotojas';
    $link    = 'login.php';    
    $btn     = 'Prisijungti';
    $style   = 'btn';
}
else{
    include 'includes/inner-admin-menu.php';
    $message = 'Prisijungęs vartotojas: '.$_SESSION['user_name'];   
    $link    = 'logout.php';    
    $btn     = 'Atsijungti';
    $style   = 'btn-blue';
}
require 'includes/db.php';
$title = "Darbuotojas";
include 'includes/inner-header.php';

$employeeID = '';
if(!empty($_GET['id']) && is_numeric($_GET['id'])) {
  $employeeID = trim($_GET['id']);
}
if($employeeID!='') {
    $sql = "SELECT employeeFirstName, employeeLastName, employeeEmail, employeePhone, imgLink FROM sz_employee WHERE employeeID='".$employeeID."'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
    
        $row = mysqli_fetch_assoc($result);
        $employeeFirstName = $row['employeeFirstName'];
        $employeeLastName = $row['employeeLastName'];
        $employeeEmail = $row['employeeEmail'];
        $employeePhone = $row['employeePhone'];
        $imgLink = $row['imgLink'];
    }

    $sql2 = "SELECT     sz_team_member.teamID,
                        sz_team.teamName, 
                        sz_role.roleName
            FROM sz_team_member 
    LEFT JOIN sz_team ON sz_team_member.teamID = sz_team.teamID
    LEFT JOIN sz_role ON sz_team_member.roleID = sz_role.roleID
    WHERE sz_team_member.employeeID=$employeeID";
    
    $result2 = mysqli_query($conn, $sql2);
    if (mysqli_num_rows($result2)>0){
        while ($row = mysqli_fetch_assoc($result2)){
          $teams[]= $row;
        }
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
                <div class = 'second-line'>
                    <h2>Darbuotojas</h2>
                    
                
                </div>
                
                <hr>
                <div class='flex'>
                    <div class= 'left'>
                        <h4>Vardas: <?php echo $employeeFirstName;?></h4>
                        <h4>Pavardė: <?php echo $employeeLastName;?></h4>
                        <p> El. paštas: <?php echo $employeeEmail;?></p>
                        <p> Telefono nr.: <?php echo $employeePhone;?></p>
                    </div>
                    <div class= 'right'>
                        <img class='foto' src='../img/avatar/<?php echo $imgLink;?>.png'>
                    </div>
                </div>

                <h3>Dirba komandose</h3>
                <hr>
                <?php 
                if (!empty($teams)):
                    $i=0; 
                ?>
                <table>
                <tr>
                <th> Eil. nr.</th>
                <th> Komandos pavadinimas</th>
                <th> Pareigos</th>
                </tr>
                <?php 
                foreach($teams as $value){
                    $i++;
                    echo '<tr>';
                    echo '<td>'.$i.'.</td>';
                    echo '<td><a class="link" href="../team.php/?id='.$value['teamID'].'&team='.$value['teamName'].'">'.$value["teamName"].'</a></td>';
                    echo '<td>'.$value["roleName"].'</td>';
                    echo '</tr>';
                    }
                ?>
                </table>
                <?php
                else:
                    echo 'Užduočių sąrašas tuščias';
                endif;
                    ?>

        </div>       
    </div>
</body>