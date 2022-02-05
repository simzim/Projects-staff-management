<?php
session_start(); 
if (!isset($_SESSION['user_name']))
{
    $message = 'Neprisijungęs vartotojas';
    $link    = 'login.php';    
    $btn     = 'Prisijungti';
    $style   = 'btn';
}
else{
    $message = 'Prisijungęs vartotojas: '.$_SESSION['user_name'];   
    $link    = 'logout.php';    
    $btn     = 'Atsijungti';
    $style   = 'btn-blue';
}
require 'includes/db.php';
$title = "Komanda";
include 'includes/inner-header.php';
include 'includes/inner-menu.php';
$teamName = '';
$teamID = '';
if(!empty($_GET['id']) && is_numeric($_GET['id']) && !empty($_GET['team'])) {
  $teamID = trim($_GET['id']);
  $teamName = trim($_GET['team']);
}

if($teamID!='') {

    $sql = "SELECT sz_employee.employeeFirstName, sz_employee.employeeLastName, sz_role.roleName , sz_team_member.employeeID
    FROM sz_team_member 
    LEFT JOIN sz_employee ON sz_team_member.employeeID = sz_employee.employeeID
    LEFT JOIN sz_role ON sz_team_member.roleID = sz_role.roleID
    WHERE sz_team_member.teamID=$teamID";
    
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_assoc($result)){
          $members[]= $row;
        }
    }


    $sql2 = "SELECT projectID, projectName, projectStartTime, projectEndTime
    FROM sz_project 
    WHERE teamID=$teamID";
    
    $result2 = mysqli_query($conn, $sql2);
    
    if (mysqli_num_rows($result2)>0){
        while ($row2 = mysqli_fetch_assoc($result2)){
          $project[]= $row2;
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
            <h2>Komanda <?php echo $teamName; ?></h2>
            <hr>
            <?php 
            if (!empty($members)):
                $i=0; 
            ?>
            <table>
            <tr>
            <th> Eil. nr.</th>
            <th> Vardas</th>
            <th> Pavardė</th>
            <th> Pareigos</th>
            </tr>
            <?php 
            foreach($members as $value){
                $i++;
                echo '<tr>';
                echo '<td>'.$i.'.</td>';
                echo '<td><a class="link" href="../person.php/?id='.$value['employeeID'].'">'.$value["employeeFirstName"].'</a></td>';
                echo '<td><a class="link" href="../person.php/?id='.$value['employeeID'].'">'.$value["employeeLastName"].'</a></td>';
                echo '<td>'.$value["roleName"].'</td>';
                echo '</tr>';
                }
            ?>
            </table>
            <?php
            else:
                echo 'Komandos dalyvių nerasta';
            endif;
                ?>
        
            <h2 class="second">Projektai</h2>
            <hr>
            <?php 
            if (!empty($project)):
                $i=0; 
            ?>
            <table>
            <tr>
            <th> Eil. nr.</th>
            <th> Pavadinimas</th>
            <th> Pradžia</th>
            <th> Pabaiga</th>
            </tr>
            <?php 
            foreach($project as $value){
                $i++;
                echo '<tr>';
                echo '<td>'.$i.'.</td>';
                echo '<td><a class="link" href="../project.php/?id='.$value['projectID'].'">'.$value["projectName"].'</a></td>';
                echo '<td>'.$value["projectStartTime"].'</td>';
                echo '<td>'.$value["projectEndTime"].'</td>';
                echo '</tr>';
                }
            ?>
            </table>
            <?php
            else:
                echo 'Komandos dalyvių nerasta';
            endif;
                ?>

        </div>  
    </div>
</body>

