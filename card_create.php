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
	else if(empty($_POST['card_id'])){
        echo "Error: The card_id can not be empty!";
        header('Refresh:2; url = card_create.html');
		exit();
    }
    else if(empty($_POST['card_name'])){
        echo "Error: The card_name can not be empty!";
        header('Refresh:2; url = card_create.html');
		exit();
    }
    else if(empty($_POST['department'])){
        echo "Error: The department can not be empty!";
        header('Refresh:2; url = card_create.html');
		exit();
    }
    else if(empty($_POST['type'])){
        echo "Error: The type can not be empty!";
        header('Refresh:2; url = card_create.html');
		exit();
    }
    else if ($_POST['type'] != 'student' && $_POST['type'] != 'teacher'){
        echo "Error: The type must be 'teacher' or 'student'!";
        header('Refresh:2; url = card_create.html');
		exit();
    }
    
    //Avail Data
    $card_id = $_POST['card_id'];
    $card_name = $_POST['card_name'];
    $department = $_POST['department'];
    $type = $_POST['type'];

    // Make connection to DB
	$link = connect_to_database('localhost', 'root', '123qweasd');

    //Check the password
    $sql = "insert into card values ($card_id, '{$card_name}', '{$department}', '{$type}');" ;
    $result = my_query($link, $sql);
    if($result){
        mysqli_close($link);
        echo '新图书证注册成功！';
        header('Refresh:2; url = static/card_create.html');
    }
    else{
        mysqli_close($link);
        echo '新图书证注册失败';
        header('Refresh:2; url = static/card_create.html');
        exit();
    }

?>