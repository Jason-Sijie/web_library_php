<?php
	header('Content-type:text/html;charset=utf-8');
	echo '<pre>';
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
	if(empty($_GET['card_id'])){
		echo "Error: Fail to submit!";
		header('Refresh:2; url = card_information.html');
		exit();
	}
	
	// Avail Data
	$card_id = $_GET['card_id'];

	// Make connection to DB
	$link = connect_to_database('localhost', 'root', '123qweasd');
		
	// Do the query
	$result = my_query($link, "delete from card where card_id = $card_id;");
	if(!$result){
		mysqli_close($link);
		echo "删除失败！";
		header('Refresh:2; url = static/card_information.html');
		exit();
	}

    // Show the result
	mysqli_close($link);
	echo "删除成功！";
    header('Refresh:2; url = static/card_information.html');
    exit();

?>