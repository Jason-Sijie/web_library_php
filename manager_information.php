<?php
	header('Content-type:text/html;charset=utf-8');
	// include helping functions
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
		header('Refresh:2; url = static/manager_information.html');
		exit();
	}
	if(!empty($_POST['all'])){
        // Make connection to DB
        $link = connect_to_database('localhost', 'root', '123qweasd');
        
        // Do the query
	    $sql = "select * from manager;";

	    //Show the result
	    $result = my_query($link,$sql);
	    $num = mysqli_num_rows($result);
	    mysqli_close($link);

    }
    else if(empty($_POST['manager_id']) && empty($_POST['manager_name']) && empty($_POST['phone'])){
        echo "The attributes can not all be blank!";
        header('Refresh:2; url = static/manager_information.html');
		exit();
    }
    else{
        // Avail Data
        $manager_id = (isset($_POST['manager_id']))? $_POST['manager_id'] : '';
        $manager_name = (isset($_POST['manager_name']))? $_POST['manager_name'] : '';
        $phone = (isset($_POST['phone']))? $_POST['phone'] : '';

	    // Make connection to DB
	    $link = connect_to_database('localhost', 'root', '123qweasd');
		
	    // Do the query
	    $sql = "select * from manager where ";
	    if(!empty($manager_id)){
	    	$sql .= "manager_id = $manager_id and ";
	    }
	    if(!empty($manager_name)){
	    	$sql .= "manager_name = '{$manager_name}' and ";
	    }
	    if(!empty($phone)){
	    	$sql .= "phone_number = $phone and ";
	    }
	    $sql = substr($sql, 0, -5);

	    //Show the result
	    $result = my_query($link,$sql);
	    $num = mysqli_num_rows($result);
	    mysqli_close($link);
    }
    
    include_once 'static/manager_information.html';
?>