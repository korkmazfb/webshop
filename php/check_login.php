<!--  Ali zijn code -->


<?php  
session_start();
include "../db_conn.php";



if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['role'])) {
	// var_dump($_POST);


	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	//   echo $data;
	  return $data;
	}

	$username = test_input($_POST['username']);
	$password = test_input($_POST['password']); 
	$role = test_input($_POST['role']);

	if (empty($username)) {
		header("Location: ../index.php?error=User Name is Required");
		exit;
	}else if (empty($password)) {
		header("Location: ../index.php?error=Password is Required");
		exit;
	}else {

		$password = md5($password);


        //De select query van mijn database
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
		// echo $username, $password;


        $result = mysqli_query($conn, $sql);
		

	

        if (mysqli_num_rows($result) === 1) {
        	$row = mysqli_fetch_assoc($result);
		var_dump($row);
		echo '<br>';
			echo $row['password'], ':', $password, $row['username'], $username;
        	
			if ($row['role'] == $role) {
        		$_SESSION['name'] = $row['name'];
        		$_SESSION['id'] = $row['id'];
        		$_SESSION['role'] = $row['role'];
        		$_SESSION['username'] = $row['username'];

        		header("Location: ../home.php");
				exit;

        	}else {
        		header("Location: ../index.php?error=Foute gebruikersnaam, wachtwoord of type!");
				exit;
        	}
        }
		else {
        	header("Location: ../index.php?error=Foute gebruikersnaam, wachtwoord of type!");
			exit;
        }

	}
	
// }else {
// 	header("Location: ../index.php");
}