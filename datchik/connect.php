<?php 
error_reporting( E_ERROR );
$connect=OCILogon("mironov", "mironov", "orcl"); 

if (!$connect) { 
	die("<h3 align='center'>Ошибка подключения к БД!</h3>"); 
	echo "Не удается подключиться к БД: " . var_dump( OCIError() ); 
}
?>