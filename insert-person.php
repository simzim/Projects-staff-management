<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    die();
}
require 'includes/db.php';
$title = 'Dashboard';
include 'includes/header.php';
include 'includes/admin-menu.php';

$sql = 'SELECT 	teamID, teamName  FROM sz_team';
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result)>0){
  while ($row = mysqli_fetch_assoc($result)){
    $team[]= $row;
  }
}
$sql1 = 'SELECT roleID, roleName  FROM sz_role';
$result1 = mysqli_query($conn, $sql1);

if (mysqli_num_rows($result1)>0){
  while ($row1 = mysqli_fetch_assoc($result1)){
    $role[]= $row1;
  }
}

$form_errors = array();

if (isset($_POST['submit'])) {

    $frstName = mysqli_real_escape_string($conn, $_POST['fname']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lname']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $phone    = mysqli_real_escape_string($conn, $_POST['phone']);
    
    $teamID   = mysqli_real_escape_string($conn, $_POST['team']);
    $roleID   = mysqli_real_escape_string($conn, $_POST['role']);

    $sql3 = "INSERT INTO sz_employee (employeeFirstName, employeeLastName, employeeEmail, employeePhone) 
    VALUES ( '$frstName', '$lastName', '$email', '$phone'); 
    -- INSERT INTO sz_team_member ( teamID, employeeID, roleID) 
    -- VALUES ('$teamID', (SELECT MAX(employeeID) FROM sz_employee), '$roleID');
    
    ";


    $result = mysqli_query($conn, $sql3);


    // Vardo tikrinimas

    // if (empty($_POST['fname'])) {
    //     $form_errors['fname1'] = '* Vardo įvedimas privalomas';
    // } else {
    //     if (strlen($_POST['fname']) < 3) {
    //         $form_errors['fname1'] = '* Per mažai simbolių';
    //     }
    // }
    
    //Pavardes tikrinimas

    // if (empty($_POST['lname'])) {
    //     $form_errors['lname1'] = '* Pavardės įvedimas privalomas';
    // } else {
    //     if (strlen($_POST['lname']) < 3) {
    //         $form_errors['lname1'] = '* Per mažai simbolių';
    //     }
    // }

    // el pašto tikrinimas

    // if (empty($_POST['email'])) {
    //     $form_errors['email1'] = '* Elektroninio pašto įvedimas privalomas';
    // } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    //     $form_errors['email1'] = '* Patikrinkite Elektroninio pašto formatą';
    // }

    //telefono tikrinimas

    // if (empty($_POST['phone'])) {
    //     $form_errors['phone1'] = '* telefono numeris privalomas';
    // } else {
    //     if (strlen($_POST['phone']) < 8) {
    //         $form_errors['phone1'] = '* Per mažai simbolių';
    //     }
    // }

    // if (empty($form_errors)) {

    //     //header('Location: insert.php');
    //     exit();
    // }
    
}
mysqli_close($conn);
?>
<body>
    <div class="main">
        <div class='top-line'>
            <p class='user-name'>Prisijungęs vartotojas: <?php echo $_SESSION['user_name']; ?></p>
            <a class='link btn-blue' href='logout.php'>Atsijungti</a>
        </div>
        <h1>Pridėti darbuotoją</h1>
        <div class='width'>
            <form method='post'>
                <input type='text' name='fname' value='<?php isset($_POST['fname']) ? $_POST['fname'] : ''; ?>'
                    placeholder='Vardas'>
                <span class='error'><?php echo isset($form_errors['fname1']) ? $form_errors['fname1'] : ''; ?></span>

                <input type='text' name='lname' value='<?php isset($_POST['fname']) ? $_POST['fname'] : ''; ?>'
                    placeholder='Pavardė'>
                <span class='error'><?php if (isset($form_errors['lname1'])) echo $form_errors['lname1']; ?></span>

                <input type='text' name='email' value='<?php if (isset($_POST['email'])) echo $_POST['email'] ?>'
                    placeholder='El paštas'>
                <span class='error'><?php if (isset($form_errors['email1'])) echo $form_errors['email1']; ?></span>

                <input type='text' name='phone' value='<?php if (isset($_POST['phone'])) echo $_POST['phone'] ?>'
                    placeholder='Telefono numeris'>
                <span class='error'><?php if (isset($form_errors['phone1'])) echo $form_errors['phone1']; ?></span>
                <label>Deleguoti į komandą</label>
                
                
                <select name="team">
                    <option value=''>Nepasirinkta</option>
                    <?php
                    foreach ($team as $value) {
                        echo "<option value=".$value['teamID'].">".$value['teamName']."</option>";
                      }
                    ?>
                </select>

                <label>Pareigos komandoje</label>
               
                <select name="role">
                    <option value=''>Nepasirinkta</option>
                    <?php
                    foreach ($role as $value) {
                        echo "<option value=".$value['roleID'].">".$value['roleName']."</option>";
                      }
                    ?>
                </select>
                <br>
                <input type='submit' value='submit' name='submit'>
            </form>
        </div>
    </div>

</body>