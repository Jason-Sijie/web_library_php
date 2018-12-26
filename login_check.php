<?php
    header('Content-type:text/html;charset=utf-8');
    include_once 'mysql_helping_functions.php';
	
	// Check input illegal
	if(!isset($_POST)){
		echo "Error: Fail to submit!";
		exit();
	}
	else if(empty($_POST['username'])){
        echo "Error: The username can not be empty!";
        header('Refresh:2; url = log_in.html');
		exit();
    }
    else if(empty($_POST['password'])){
        echo "Error: The password can not be empty!";
        header('Refresh:2; url = log_in.html');
		exit();
    }
    
    //Avail Data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Make connection to DB
	$link = connect_to_database('localhost', 'root', '123qweasd');

    //Check the password
    $sql = "select * from manager where manager_id = '{$username}' and password = MD5('{$password}');" ;
    $result = my_query($link, $sql);
    if(mysqli_num_rows($result)){
        // Open session
        session_start();
        
        // Get manager_name
        $row = mysqli_fetch_assoc($result);
        $manager_name = $row['manager_name'];

        // Set the session data
        $_SESSION['manager_name'] = $manager_name;

        mysqli_close($link);
        header('Refresh:0; url = home.php');
    }
    else{
        mysqli_close($link);
        echo 'Wrong username or password!';
        header('Refresh:2; url = static/log_in.html');
        exit();
    }

?>