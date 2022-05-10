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
		if(strcmp($_POST['login'], $_SESSION['login']))
		{
			$sql_parse = OCIParse($connect, "DELETE FROM users WHERE login = '".trim($_POST['login'])."'");
			OCIExecute($sql_parse, OCI_DEFAULT);
			OCICommit($connect);
			$_SESSION['error']='Пользователь удален';	
		}
		else
		{
			$_SESSION['error']='Вы не можете удалить свой профиль';
		}
	}
?>
<html>

<head>
	<meta charset="utf8">
	<link href="../style.css" rel="stylesheet">
	<title>Удаление пользователя</title>
	
</head>

<header>
	АСУ ТП изготовления "Датчик уровня воды"<br>
	Удаление пользователя
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
			<form action="delete_users.php" method="POST" class="authform">
				Выберите логин удаляемого пользователя<br>
				<select class='roles' name='login'>
					<?php
						$sql_parse = OCIParse($connect , "SELECT * FROM users");
						OCIExecute($sql_parse, OCI_DEFAULT);
						while(OCIFetch($sql_parse))
						{
							echo "<option value=".OCIResult($sql_parse, 'LOGIN').">".OCIResult($sql_parse, 'LOGIN')."</option>";
						}
					?>
				</select><br><br>
				<input type='submit'   class='ok' value='Удалить' name='ok'></submit><br><br>
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