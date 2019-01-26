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
		header('Refresh:2; url = static/return_search.html');
		exit();
	}
    else if(empty($_POST['card_id'])){
        echo "The card_id can not be blank!";
        header('Refresh:2; url = static/return_search.html');
		exit();
    }
    else if(empty($_POST['book_id'])){
        echo "The book_id can not be blank!";
        header('Refresh:2; url = static/return_search.html');
		exit();
    }

    // Avail Data
    $card_id = (isset($_POST['card_id']))? $_POST['card_id'] : '';
    $book_id = (isset($_POST['book_id']))? $_POST['book_id'] : '';

    // connect to the database
    $link = connect_to_database('localhost', 'root', '123qweasd');
    
    // check whether he had borrowed the book
    $sql = "select * from record where card_id = $card_id and book_id = $book_id;";
    $result = my_query($link, $sql);
    $num = mysqli_num_rows($result);
    $result = mysqli_fetch_assoc($result);
    $temp = $result['return_date'];
    if ($num == 0 || !empty($temp)){
        echo "没有该书的借书记录";
        header("Refresh:2; url = return_search.php?card_id=$card_id");
		exit();
    }
    else{
        $return_date = date('Y/m/d');
        $sql = "update record set return_date = '{$return_date}' where card_id = $card_id and book_id = $book_id;";
        $result = my_query($link, $sql);
        $sql = "update book set stock = stock + 1 where book_id = $book_id;";
        $result = my_query($link, $sql);
    }

	mysqli_close($link);    
        
    echo "还书成功！";
    header("Refresh:2; url = return_search.php?card_id=$card_id");
?>