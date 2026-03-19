<?php require_once '../../config.php';

    unset($_SESSION['ADMIN_USER']['ID']);
	session_destroy(); //destroy the session
	header('location:'.APP_URL.'/login'); 
	exit();
?>
