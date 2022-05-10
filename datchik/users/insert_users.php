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
		if(!trim($_POST['login']))
		{
			$_SESSION['error']='Введите логин';
		}
		elseif(!trim($_POST['password']))
		{
			$_SESSION['error']='Введите пароль';
		}
		elseif(!trim($_POST['username']))
		{
			$_SESSION['error']='Введите имя пользователя';
		}
		else
		{
			$check_parse = OCIParse($connect, "SELECT * FROM users WHERE login = '".trim($_POST['login'])."'");
			OCIExecute($check_parse, OCI_DEFAULT);
			OCIFetch($check_parse);
			if(!strcmp($_POST['login'], OCIResult($check_parse, 'LOGIN')))
			{
				$_SESSION['error']='Такой логин уже существует';
			}
			else
			{
				$ins_parse = OCIParse($connect, "INSERT INTO users (login, password, username, user_role)
							VALUES ('".trim($_POST['login'])."', '".trim($_POST['password'])."'
							, '".trim($_POST['username'])."', '".trim($_POST['user_role'])."')");
				OCIExecute($ins_parse, OCI_DEFAULT);
				OCICommit($connect);
				$_SESSION['error']='Пользователь добавлен';
			}
		}
	}
?>
<html>

<head>
	<meta charset="utf8">
	<link href="../style.css" rel="stylesheet">
	<title>Добавить пользователя</title>
	
</head>

<header>
	АСУ ТП изготовления "Датчик уровня воды"<br>
	Добавление пользователя
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
			<form action="insert_users.php" method="POST" class="authform">
				Введите логин<br>
				<input type='textarea' class='login' name='login'><br>
				Введите пароль<br>
				<input type='textarea' class='login' name='password'><br>
				Введите имя пользователя<br>
				<input type='textarea' class='login' name='username'><br>
				Выберите роль<br>
				<select class='roles' name='user_role'>
					<option value="administrator">administrator</option>
					<option value="moderator">moderator</option>
					<option value="user">user</option>
				</select><br><br>
				<input type='submit'   class='ok' value='Добавить' name='ok'></submit><br><br>
				<?php
					if($_SESSION['error'])
					{
						echo "<font color='red'>".$_SESSION['error']."</font>";
					}
				?>
			</form>
		</div>
		<?php
			unset($sql_parse, $_POST['login'], $_POST['password'], $_POST['username'], $_POST['user_role'], $_POST['ok'], $_SESSION['error']);
			require ("../disconnect.php");
		?>
	</div>
	<div class="footer">
			© Миронов Кирилл ИУ4-83Б
	</div>
</body>

</html>