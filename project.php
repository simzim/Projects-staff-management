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
$title = "Projektas";
include 'includes/inner-header.php';

$projectID = '';
if(!empty($_GET['id']) && is_numeric($_GET['id'])) {
    $projectID = trim($_GET['id']);
}
if($projectID!='') {

    $sql2 = "SELECT 	projectName  FROM sz_project WHERE projectID = '".$projectID."'";
    $result2 = mysqli_query($conn, $sql2);
    if (mysqli_num_rows($result2) == 1) {
        $row = mysqli_fetch_assoc($result2);
        $projectName = $row['projectName'];
    }

    $sql = "SELECT  sz_task.taskName, 
                    sz_task.taskDescription, 
                    sz_task_mode.taskMode,
                    sz_employee.employeeID,
                    sz_employee.employeeFirstName
    FROM sz_task
    LEFT JOIN sz_task_mode ON sz_task.taskModeID = sz_task_mode.taskModeID
    INNER JOIN sz_team_member ON sz_team_member.teamMemberID = sz_task.teamMemberID
    INNER JOIN sz_employee ON sz_team_member.employeeID = sz_employee.employeeID
    WHERE sz_task.projectID = $projectID";
    
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_assoc($result)){
          $tasks[]= $row;
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
            <h2>Projektas: <?php echo $projectName; ?></h2>
            <hr>
            <?php 
            if (!empty($tasks)):
                $i=0; 
            ?>
            <table>
            <tr>
            <th> Eil. nr.</th>
            <th> Užduoties pavadinimas</th>
            <th> Aprašymas</th>
            <th> Stadija</th>
            <th> Atsakingo asmens vardas</th>
            </tr>
            <?php 
            foreach($tasks as $value){
                $i++;
                echo '<tr>';
                echo '<td>'.$i.'.</td>';
                echo '<td>'.$value["taskName"].'</td>';
                echo '<td>'.$value["taskDescription"].'</td>';
                echo '<td>'.$value["taskMode"].'</td>';
                echo '<td><a class="link" href="../person.php/?id='.$value['employeeID'].'">'.$value["employeeFirstName"].'</a></td>';
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