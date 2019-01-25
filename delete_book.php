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
	if(empty($_GET['book_id'])){
		echo "Error: Fail to submit!";
		header('Refresh:2; url = static/manage_book.html');
		exit();
	}
	
	// Avail Data
	$book_id = $_GET['book_id'];

	// Make connection to DB
	$link = connect_to_database('localhost', 'root', '123qweasd');
		
	// Do the query
	$result = my_query($link, "delete from book where book_id = $book_id;");
	if(!$result){
		mysqli_close($link);
		echo "删除失败！";
		header('Refresh:2; url = static/manage_book.html');
		exit();
	}

    // Show the result
	mysqli_close($link);
	echo "删除成功！";
    header('Refresh:2; url = static/manage_book.html');
    exit();

?>