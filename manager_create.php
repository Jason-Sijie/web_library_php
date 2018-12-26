<?php
    header('Content-type:text/html;charset=utf-8');
    include_once 'mysql_helping_functions.php';
    
    // Open session
    session_start();
	
	// Check authority
	if(empty($_SESSION['manager_name'])){
		echo 'Error: You must login first!';
		header('Refresh:2; url = index.html');
		exit();
	}
	$name = $_SESSION['manager_name'];

	// Check input illegal
	if(!isset($_POST)){
		echo "Error: Fail to submit!";
		exit();
	}
	else if(empty($_POST['manager_id'])){
        echo "Error: The manager_id can not be empty!";
        header('Refresh:2; url = static/manager_create.html');
		exit();
    }
    else if(empty($_POST['manager_name'])){
        echo "Error: The manager_name can not be empty!";
        header('Refresh:2; url = static/manager_create.html');
		exit();
    }
    else if(empty($_POST['password'])){
        echo "Error: The password can not be empty!";
        header('Refresh:2; url = static/manager_create.html');
		exit();
    }
    else if(empty($_POST['phone'])){
        echo "Error: The phone number can not be empty!";
        header('Refresh:2; url = static/manager_create.html');
		exit();
    }
    
    //Avail Data
    $manager_id = $_POST['manager_id'];
    $manager_name = $_POST['manager_name'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];

    // Make connection to DB
	$link = connect_to_database('localhost', 'root', '123qweasd');

    //Check the password
    $sql = "insert into manager values ($manager_id, '{$manager_name}', MD5('{$password}'), $phone);" ;
    $result = my_query($link, $sql);
    if($result){
        mysqli_close($link);
        echo '新管理员注册成功！';
        header('Refresh:2; url = static/manager_create.html');
    }
    else{
        mysqli_close($link);
        echo '新管理员注册失败';
        header('Refresh:2; url = static/manager_create.html');
        exit();
    }

?>