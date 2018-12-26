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
	if(!isset($_POST) || empty($_POST['card_id'])){
		echo "Error: Fail to submit!";
		header('Refresh:2; url = static/borrow_search.html');
		exit();
	}
    else if(empty($_POST['book_id'])){
        echo "The book_id can not be blank!";
        header('Refresh:2; url = static/borrow_search.html');
		exit();
    }

    // Avail Data
    $book_id = (isset($_POST['book_id']))? $_POST['book_id'] : '';
    $card_id = (isset($_POST['card_id']))? $_POST['card_id'] : '';
    $current_date =  date('Y/m/d');

	// Make connection to DB
	$link = connect_to_database('localhost', 'root', '123qweasd');
    
    // check the stock of book
    $sql = "select stock from book where book_id = $book_id;";
    $result = my_query($link,$sql);
    if(!mysqli_num_rows($result)){
        echo "The book_id was wrong!";
        header('Refresh:2; url = static/borrow_search.html');
		exit();
    }
    $result = mysqli_fetch_assoc($result);
    $stock = $result['stock'];
    if($stock == 0){
        echo "错误：该书无库存!". '<br>';
        echo "最近归还时间：";
        $sql = "select max(return_time) from record where book_id = $book_id;";
        $result = my_query($link, $sql);
        $result = mysqli_fetch_assoc($result);
        $time = $result['max(return_time)'];
        if(empty($time)){
            echo "无";
        }
        else{
            echo "$time";
        }
        header('Refresh:2; url = static/borrow_search.html');
		exit();
    }
    else {
        $sql = "select * from record where card_id = $card_id and book_id = $book_id;";
        $result = my_query($link, $sql);
        $result = mysqli_fetch_assoc($result);
        $rt = $result['return_time'];
        if (!empty($rt)){
            $sql = "delete from record where card_id = $card_id and book_id = $book_id;";
            $result = my_query($link, $sql);
        } 
        else if(!empty($result)){
            echo "Error: You can not borrow the same book more than once!";
            header("Refresh:2; url = borrow_search.php?card_id=$card_id");
            exit();
        }
        
    }

	// Do the query
    $sql = "update book set stock = stock-1 where book_id = $book_id";
    $result = my_query($link,$sql);
    
    $sql = "insert into record values ($card_id, $book_id, '{$current_date}', null)";
    $result = my_query($link,$sql);
    mysqli_close($link);    

    echo "借书成功！";
    header("Refresh:2; url = borrow_search.php?card_id=$card_id");

?>