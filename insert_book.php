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
		header('Refresh:2; url = static/insert_book.html');
		exit();
	}
	if(empty($_POST['book_name']) || empty($_POST['book_id']) || empty($_POST['type']) || empty($_POST['author']) || empty($_POST['publisher'])
	|| empty($_POST['year']) || empty($_POST['price']) || empty($_POST['number'])){
		echo "Error: All the attributes should have been filled!";
		header('Refresh:2; url = static/insert_book.html');
		exit();
	}
	else if(!empty($_POST['number']) && $_POST['number'] <= 0){
		echo "Error: The number can not be less than or equal to 0!";
		header('Refresh:2; url = static/insert_book.html');
		exit();
	}
	
	// Make connection to DB
	$link = connect_to_database('localhost', 'root', '123qweasd');	

	// Avail Data
	$book_id = (isset($_POST['book_id']))? $_POST['book_id'] : '';
	$book_name = (isset($_POST['book_name']))? $_POST['book_name'] : '';
	$type = (isset($_POST['type']))? $_POST['type'] : '';
	$publisher = (isset($_POST['publisher']))? $_POST['publisher'] : '';
	$author = (isset($_POST['author']))? $_POST['author'] : '';
	$price = (isset($_POST['price']))? $_POST['price'] : '';
	$year = (isset($_POST['year']))? $_POST['year'] : '';
	$number = (isset($_POST['number']))? $_POST['number'] : '';
	$total_number = 0;
	$stock = 0;
	
	// Insert one book into DB
	if(!insert_one_book($link, $book_id, $type, $book_name, $publisher, $year, $author, $price, $number, $total_number, $stock)){
		mysqli_close($link);
		header('Refresh:2; url = static/insert_book.html');
		exit();
	}
	else{
		mysqli_close($link);
	}
	
	include_once 'static/insert_book.html'

?>