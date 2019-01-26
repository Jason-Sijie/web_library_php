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
	if(!isset($_GET)){
		echo "Error: Fail to submit!";
		header('Refresh:2; url = static/return_search.html');
		exit();
	}
    else if(empty($_GET['card_id'])){
        echo "The card_id can not be blank!";
        header('Refresh:2; url = static/return_search.html');
		exit();
    }

    // Avail Data
	$card_id = (isset($_GET['card_id']))? $_GET['card_id'] : '';

	// Make connection to DB
	$link = connect_to_database('localhost', 'root', '123qweasd');
	
	// Do the query
	$sql = "select card_name from card where card_id = $card_id;";
	$result = my_query($link,$sql);
	$num = mysqli_num_rows($result);

	if($num == 0){
		mysqli_close($link);  
		echo "Error: The card_id was not registered!";
		header('Refresh:2; url = static/borrow_search.html');
		exit();
	}
	$result = mysqli_fetch_assoc($result);
    $card_name = $result['card_name'];

	//Show the result
    $sql = "select book_name, total_number, stock from book where book_id in (select book_id from record where card_id = $card_id);";
    $result_book = my_query($link,$sql);
    $sql = "select * from record where card_id = $card_id;";
    $result_record =  my_query($link,$sql);

	$books = array();
	while ($book = mysqli_fetch_assoc($result_book)){
		$books[] = $book;
	}

	$num = mysqli_num_rows($result_record);
	mysqli_close($link);    
		
	include_once 'static/return_search_result.html'
?>
