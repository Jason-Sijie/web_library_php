<?php
	session_start();
	
	// Check authority
	if(empty($_SESSION['manager_name'])){
		echo 'Error: You must login first!';
		header('Refresh:2; url = index.html');
		exit();
	}
	else{
        unset($_SESSION['manager_name']);
        echo '退出登陆成功';
        header('Refresh:2; url = index.html');
		exit();
    }

?>