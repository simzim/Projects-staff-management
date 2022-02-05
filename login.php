<?php
require 'includes/db.php';
$title = 'Prisijungimas';
include 'includes/header.php';
include 'includes/menu.php';
session_start();
$error = '';

if (isset($_POST['submit'])) {
    
    $userName = mysqli_real_escape_string($conn,$_POST['user_name']);
    $userPsw  = mysqli_real_escape_string($conn, $_POST['password']);
    $userPsw  = md5($userPsw); 
    
    if (empty($userName && $userPsw)){
        $error = 'Vartotojo vardas ir slaptažodis yra privalomas';
    }
    else{
        $sql = "SELECT * FROM sz_user WHERE userName = '$userName' AND userPsw = '$userPsw'";
        $result = mysqli_query ($conn, $sql);
        if (mysqli_num_rows($result)>0){
            $_SESSION['user_name']=$userName;
            header('Location: admin.php'); 
        }
        else{
            $error = 'Neteisingas vartotojo vardas arba slaptazodis'; 
        }
    }
} 
mysqli_close($conn);		
?>
	<body>
  		<div class='main for-log'>
			<span class='error'> <?php  echo isset($error)? $error : '';   ?></span>
			<div class='form'>
		    	<form class='login-form' method='post'>
		      		<input type='text' name='user_name'  placeholder='Vartotojo vardas'/>
		      		<input type='password' name='password' placeholder='slaptažodis'/>
                    <button type='submit' name='submit'>Prisijungti</button>
                </form>
		  	</div>
		</div>
	</body>
</html>