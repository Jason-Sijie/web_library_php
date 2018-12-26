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
		header('Refresh:2; url = static/card_information.html');
		exit();
	}
	if(!empty($_POST['all'])){
        // Make connection to DB
        $link = connect_to_database('localhost', 'root', '123qweasd');
        
        // Do the query
	    $sql = "select * from card;";

	    //Show the result
	    $result = my_query($link,$sql);
	    $num = mysqli_num_rows($result);
	    mysqli_close($link);

    }
    else if(empty($_POST['card_id']) && empty($_POST['card_name']) && empty($_POST['department']) && empty($_POST['type'])){
        echo "The attributes can not all be blank!";
        header('Refresh:2; url = static/card_information.html');
		exit();
    }
    else{
        // Avail Data
        $card_id = (isset($_POST['card_id']))? $_POST['card_id'] : '';
        $card_name = (isset($_POST['card_name']))? $_POST['card_name'] : '';
        $department = (isset($_POST['department']))? $_POST['department'] : '';
        $type = (isset($_POST['type']))? $_POST['type'] : '';

	    // Make connection to DB
	    $link = connect_to_database('localhost', 'root', '123qweasd');
		
	    // Do the query
	    $sql = "select * from card where ";
	    if(!empty($card_id)){
	    	$sql .= "card_id = $card_id and ";
	    }
	    if(!empty($card_name)){
	    	$sql .= "name = '{$card_name}' and ";
	    }
	    if(!empty($department)){
	    	$sql .= "department = '{$department}' and ";
	    }
	    if(!empty($type)){
	    	$sql .= "type = '{$type}' and ";
	    }
	    $sql = substr($sql, 0, -5);

	    //Show the result
	    $result = my_query($link,$sql);
	    $num = mysqli_num_rows($result);
	    mysqli_close($link);
    }
    
    include_once 'static/card_information.html'
?>
