<?php
    header('Content-type:text/html;charset=utf-8');
    // include helping function
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

    // upload the file
    $file = $_FILES['books'];
    $error = '';
    $path = 'uploads';
    $allow_type = array();
    $allow_format = array('.csv');
    $max_size = 8000000;

    $filename = upload_single($file, $allow_type, $path, $error, $allow_format, $max_size);
    if($filename == false){
        echo "$error";
        header('Refresh:2; url = static/insert_book.html');
        exit();
    }
    
    // open DB
    $link = connect_to_database('localhost', 'root', '123qweasd');	

    // read the file
    $file = fopen('uploads/'.$filename, 'r');
    while($data = fgetcsv($file)){
        $book_id = $data[0];
        $book_name = iconv('gb2312','utf-8',$data[1]);
        $type = iconv('gb2312','utf-8',$data[2]);
        $author = iconv('gb2312','utf-8',$data[3]);
        $publisher = iconv('gb2312','utf-8',$data[4]);
        $year = $data[5];
        $price = $data[6];
        $number = $data[7];
        $total_number = 0;
        $stock = 0;
        if(!insert_one_book($link, $book_id, $type, $book_name, $publisher, $year, $author, $price, $number, $total_number, $stock)){
            echo "Inserting the book (book_id = $book_id) fails!";
        }
    }
    mysqli_close($link);
    fclose($file);

    echo '所有书籍录入完毕！';
    header('Refresh:2; url = static/insert_book.html');
    exit();


?>