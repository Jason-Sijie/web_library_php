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
		header('Refresh:2; url = static/manage_book.html');
		exit();
	}
	if(empty($_POST['book_name']) && empty($_POST['author']) && empty($_POST['publisher']) && empty($_POST['type'])
	&& empty($_POST['year_start']) && empty($_POST['year_end']) && empty($_POST['price_high']) && empty($_POST['price_low']) ){
		echo "The attributes can not all be blank!";
		header('Refresh:2; url = static/manage_book.html');
		exit();
	}
	
	// Avail Data
	$book_name = (isset($_POST['book_name']))? $_POST['book_name'] : '';
	$author = (isset($_POST['author']))? $_POST['author'] : '';
	$publisher = (isset($_POST['publisher']))? $_POST['publisher'] : '';
	$type = (isset($_POST['type']))? $_POST['type'] : '';
	$year_start = (isset($_POST['year_start']))? $_POST['year_start'] : '';
	$year_end = (isset($_POST['year_end']))? $_POST['year_end'] : '';
	$price_high = (isset($_POST['price_high']))? $_POST['price_high'] : '';
	$price_low = (isset($_POST['price_low']))? $_POST['price_low'] : '';

	// Make connection to DB
	$link = connect_to_database('localhost', 'root', '123qweasd');
		
	// Do the query
	$sql = "select * from book where ";
	if(!empty($author)){
		$sql .= "author = '{$author}' and ";
	}
	if(!empty($book_name)){
		$sql .= "book_name = '{$book_name}' and ";
	}
	if(!empty($publisher)){
		$sql .= "publisher = '{$publisher}' and ";
	}
	if(!empty($type)){
		$sql .= "type = '{$type}' and ";
	}
	if(!empty($year_start)){
		$sql .= "year >= '{$year_start}' and ";
	}
	if(!empty($year_end) ){
		$sql .= "year <= '{$year_end}' and ";
	}
	if(!empty($price_low)){
		$sql .= "price >= '{$price_low}' and ";
	}
	if(!empty($price_high) ){
		$sql .= "price <= '{$price_high}' and ";
	}
	$sql = substr($sql, 0, -5);

	//Show the result
	$result = my_query($link,$sql);
	$num = mysqli_num_rows($result);
	$book = array();
	mysqli_close($link);

	include_once 'static/manage_book.html'

?>

