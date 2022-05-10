<?php
	require ("../connect.php");
	session_start();
	$_SESSION['error']='';
	if(!$_SESSION['user_role'])
	{
		header('Location: authorization.php');
		exit();
	}
	error_reporting( E_ERROR );
	
	if(isset($_POST['ok']))
	{
		$sel_parse = OCIParse($connect, "SELECT * FROM users WHERE
								login = '".$_POST['oldlogin']."'");
		OCIExecute($sel_parse, OCI_DEFAULT);
		OCIFetch($sel_parse);
		if(!trim($_POST['login']))
		{
			$login = OCIResult($sel_parse, 'LOGIN');
		}
		else
		{
			$login = trim($_POST['login']);
		}
		
		if(!trim($_POST['password']))
		{
			$password = OCIResult($sel_parse, 'PASSWORD');
		}
		else
		{
			$password = trim($_POST['password']);
		}
		
		if(!trim($_POST['username']))
		{
			$username = OCIResult($sel_parse, 'USERNAME');
		}
		else
		{
			$username = trim($_POST['username']);
		}
		
		$upd_parse = OCIParse($connect, "UPDATE users 
					SET login = '".$login."'
					, password = '".$password."'
					, username = '".$username."'
					, user_role = '".$_POST['user_role']."'
					WHERE login = '".$_POST['oldlogin']."'");
		OCIExecute($upd_parse, OCI_DEFAULT);
		OCICommit($upd_parse);
		$_SESSION['error'] = 'Изменение успешно';
	}
?>

<html>

<head>
	<meta charset="utf8">
	<link href="../style.css" rel="stylesheet">
	<title>Изменение пользователя</title>
	
</head>

<header>
	АСУ ТП изготовления "Датчик уровня воды"<br>
	Изменение пользователя
</header>

<body>
	<div class="mainbody">
		<div class="menu">
			<?php
				echo "Добро пожаловать, ".$_SESSION['user']."<br>Ваша роль: ".$_SESSION['user_role']."<br>";
			?>
			<a href="users.php">Назад</a><br>
			<br>
			<a href="../index.php">На главную</a><br>
			<ul>
				<?php
					if(!strcmp($_SESSION['user_role'], 'administrator')||!strcmp($_SESSION['user_role'], 'moderator'))
					{
						echo "<li><a href='users.php'>Управление пользователями</a></li>";
					}
				?>
				<li><a href="../equipment/equipment.php">Оборудование</a></li>
				<li><a href="../rig/rig.php">Оснастка</a></li>
				<li><a href="../personal/personal.php">Персонал</a></li>
				<li><a href="../operations/operations.php">Операции</a></li>
				<li><a href="../documents/documents.php">Документы</a></li>
				<li><a href="../devices/devices.php">Устройства</a></li>
			</ul>
		</div>
		<div class='content'>
			<h3 align='center'>Форма для ввода</h3>
			<form action="edit_users.php" method="POST" class="authform">
				Выберите логин изменяемого пользователя<br>
				<select class='roles' name='oldlogin'>
					<?php
						$sql_parse = OCIParse($connect , "SELECT * FROM users");
						OCIExecute($sql_parse, OCI_DEFAULT);
						while(OCIFetch($sql_parse))
						{
							echo "<option value=".OCIResult($sql_parse, 'LOGIN').">".OCIResult($sql_parse, 'LOGIN')."</option>";
						}
					?>
				</select><br><br>
				Введите новый логин<br>
				<input type='textarea' class='login' name='login'><br>
				Введите новый пароль<br>
				<input type='textarea' class='login' name='password'><br>
				Введите новое имя пользователя<br>
				<input type='textarea' class='login' name='username'><br>
				Выберите роль<br>
				<select class='roles' name='user_role'>
					<option value="administrator">administrator</option>
					<option value="moderator">moderator</option>
					<option value="user">user</option>
				</select><br><br>
				<input type='submit'   class='ok' value='Изменить' name='ok'></submit><br><br>
				<?php
					if($_SESSION['error'])
					{
						echo "<font color='red'>".$_SESSION['error']."</font>";
					}
				?>
			</form>
		</div>
		<?php
			unset($sql_parse, $_POST['login'], $_POST['ok'], $_SESSION['error']);
			require ("../disconnect.php");
		?>
	</div>
	<div class="footer">
			© Миронов Кирилл ИУ4-83Б
	</div>
</body>

</html>