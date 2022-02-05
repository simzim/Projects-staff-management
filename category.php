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
$title = "Kategorija";
include 'includes/inner-header.php';


$categoryID = '';
if(!empty($_GET['id']) && is_numeric($_GET['id'])) {
  $categoryID = trim($_GET['id']);
}
if($categoryID!='') {
    $sql = "SELECT categoryName, categoryDescription FROM sz_category WHERE categoryID= $categoryID ";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $categoryName = $row['categoryName'];
        $categoryDescription = $row['categoryDescription'];
    }

    
    $sql2 = "SELECT sz_project.projectID, 
                    sz_project.teamID, 
                    projectName, 
                    projectStartTime, projectEndTime, sz_team.teamName
    
    FROM sz_project 
    LEFT JOIN sz_team ON sz_project.teamID = sz_team.teamID
    
    WHERE categoryID= $categoryID";


    
    $result2 = mysqli_query($conn, $sql2);
    if (mysqli_num_rows($result2) >0) {
      while ($row = mysqli_fetch_assoc($result2)){
        $projects[]= $row;
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
            <h2><?php echo $categoryName;?></h2>
            <hr>
            <p>Trumpas kategorijos aprašymas:</p>
            <p><?php echo $categoryDescription;?></p>


            <h2 class="second">Projektai</h2>
            <hr>
            <?php 
            if (!empty($projects)):
                $i=0; 
            ?>
            <table>
            <tr>
            <th> Eil. nr.</th>
            <th> Pavadinimas</th>
            <th> Pradžia</th>
            <th> Pabaiga</th>
            <th> Komanda</th>
            </tr>
            <?php 
            foreach($projects as $value){
                $i++;
                echo '<tr>';
                echo '<td>'.$i.'.</td>';
                echo '<td><a class="link" href="../project.php/?id='.$value['projectID'].'">'.$value["projectName"].'</a></td>';
                echo '<td>'.$value["projectStartTime"].'</td>';
                echo '<td>'.$value["projectEndTime"].'</td>';
                echo '<td><a class="link" href="../team.php/?id='.$value['teamID'].'&team='.$value['teamName'].'">'.$value["teamName"].'</a></td>';
                echo '</tr>';
                }
            ?>
            </table>
            <?php
            else:
                echo 'Projektų nerasta';
            endif;
                ?>

        </div> 

    </div>
</body>