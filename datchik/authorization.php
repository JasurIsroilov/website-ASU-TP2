<?php
	session_start();
	$_SESSION['error']='';
	
	if(isset($_POST['ok']))
	{
		error_reporting( E_ERROR );
		require("connect.php");
		
		if(!trim($_POST['login']))
		{
			$_SESSION['error'] = "Введите логин";
			$_SESSION['auth_flag'] = false;
			unset($sql_parse, $_POST['password'], $_POST['login'], $_POST['ok']);
		}
		elseif(!trim($_POST['password']))
		{
			$_SESSION['error'] = "Введите пароль";
			$_SESSION['auth_flag'] = false;
			unset($sql_parse, $_POST['password'], $_POST['login'], $_POST['ok']);
		}
		else
		{
			$sql_parse = OCIParse($connect, "SELECT * FROM users WHERE login ='".trim($_POST['login'])."' 
									AND password ='".trim($_POST['password'])."'");
			OCIExecute($sql_parse, OCI_DEFAULT);
			while(OCIFetch($sql_parse))
			{
				$_SESSION['user'] = OCIResult($sql_parse, 'USERNAME');
				$_SESSION['user_role'] = OCIResult($sql_parse, 'USER_ROLE');
				$_SESSION['auth_flag'] = true;
				$_SESSION['login'] = trim($_POST['login']);
				require ("disconnect.php");
				header ('Location: index.php');
				unset($sql_parse, $_POST['password'], $_POST['login'], $_SESSION['error'], $_POST['ok']);
				exit();
			}
			$_SESSION['error'] = "Пользователь не найден";
			$_SESSION['auth_flag'] = false;
			require ("disconnect.php");
			unset($sql_parse, $_POST['password'], $_POST['login'], $_POST['ok']);
		}
	}
?>

<html>

<head>
	<meta charset="utf8">
	<link href="style.css" rel="stylesheet">
	<title>Авторизация</title>
	
</head>

<header>
	АСУ ТП изготовления "Датчик уровня воды"
</header>

<body>
	<div class="auth">
		<h3 align="center">Авторизация</h3>
		<form action='authorization.php' method="POST" class="authform">
			Логин<br>
			<input type='textarea' class='login' name='login'><br><br>
			Пароль<br>
			<input type='password' class='password' name='password'><br><br>
			<input type='submit'   class='ok' value='Войти' name='ok'></submit><br><br>
			<?php
				if($_SESSION['error'])
				{
					echo "<font color='red'>".$_SESSION['error']."</font>";
				}	
			?>
		</form>
		
	</div>
	<div class="footer">
			© Миронов Кирилл ИУ4-83Б
	</div>
</body>

</html>
