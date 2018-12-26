<?php
	//$sql is the sql instruction
	//$link is the connection with DB
	//It returns the sql result
	function my_query($link, $sql){
		$result = mysqli_query($link, $sql);
		if(!$result){
			echo 'Error number: ' . mysqli_errno($link) . '<br>';
			echo 'Error information: ' . mysqli_error($link) . '<br>';
			exit();
		}
		else{
			return $result;
		}
	}

	// array $file, 需要上传的文件信息
	// array $allow_type, 允许上传的MIME类型
	// string $path, 存储的路径
	// string &$error, 如果出现错误的原因
	// array $allow_format, 允许上传的文件格式
	// int $max_size = 2000000, 允许上传的最大值
	function upload_single($file, $allow_type, $path, &$error, $allow_format, $max_size){
		if(!is_array($file) || !isset($file['error'])){
			$error = '';
			return false;
		}
		// 判断路径是否有效
		if(!is_dir($path)){
			$error = '文件存储路径不存在！';
			return false;
		}

		switch($file['error']){
			case 1:
			case 2:
				$error = '文件超出服务器允许大小！';
				return false;
			case 3:
				$error = '文件上传过程中出现问题，只上传一部分！';
				return false;
			case 4:
				$error = '用户没有选中要上传的文件！';
				return false;
			case 6:
			case 7:
				$error = '文件保存失败！';
				return false;
		}
		
		//判断MIME类型
		if(!in_array($file['type'], $allow_type) && !empty($allow_type)){
			$error = '当前文件类型不允许上传！';
			return false;
		}

		//判断后缀是否允许
		$ext = ltrim(strrchr($file['name'], '.'));
		if(!empty($allow_format) && !in_array($ext, $allow_format) ){
			echo $ext;
			$error = '当前文件的格式不允许上传！';
			return false;
		}

		//判断文件的大小
		if($file['size'] > $max_size){
			$error = '当前上传的文件超出大小，大小为' . $max_size . '字节！';
		}

		//构造文件名字，移动到指定目录
		if(!is_uploaded_file($file['tmp_name'])){
			$error = '错误：不是上传文件！';
			return false;
		}
		if(move_uploaded_file($file['tmp_name'], $path . '/' . $file['name'])){
			return $file['name'];
		}
		else{
			$error = '文件上传失败！';
			return false;
		}

	}

	// function: insert one book into the DB
	function insert_one_book($link, $book_id, $type, $book_name, $publisher, $year, $author, $price, $number, &$total_number, &$stock){
		$result = my_query($link,"select * from Book where book_id = $book_id");
		$num1 = mysqli_num_rows($result);
		if($num1 != 0){
			$result = my_query($link,"select * from Book where book_id = $book_id and book_name = '{$book_name}' and author = '{$author}' and type = '{$type}' and publisher = '{$publisher}' and price = '{$price}' and year = '{$year}';");
			$num2 = mysqli_num_rows($result);
			if($num2 == 0){
				echo "Error: The book_id were already used by other book!";
				return false;
			}
		else{
				$result = my_query($link, "update book set total_number = total_number + $number, stock = stock + $number where book_id = $book_id;");
				$result = my_query($link, "select total_number, stock from book where book_id = $book_id;");
				$row = mysqli_fetch_assoc($result);
				$total_number = $row['total_number'];
				$stock = $row['stock'];
				return true;
			}
		}
		else{
			$result = my_query($link,"insert into Book values ($book_id, '{$type}', '{$book_name}', '{$publisher}', $year, '{$author}', $price, $number, $number);");
			$total_number = $number;
			$stock = $number;
			return true;
		}
	}

	// function: connect to the database server
	// parameters:
	// 		hostname: database host name
	//		username: database user's name
	//		password: according user's password
	function connect_to_database($hostname, $username, $password){
		// Make connection to DB
		$link = mysqli_connect($hostname, $username, $password);
		if(!$link){
			echo 'Fail to connect the database';
			exit();
		}
		mysqli_set_charset($link, 'utf8');
		my_query($link, 'use library;');
		return $link;
	}

?>