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
	
	if(isset($_GET['ok']))
	{
		if(!trim($_GET['rig_name']))
		{
			$_SESSION['error']='Введите название';
		}
		elseif(!trim($_GET['rig_type']))
		{
			$_SESSION['error']='Введите тип';
		}
		else
		{
			$check_parse = OCIParse($connect, "SELECT * FROM rig WHERE rig_name = '".trim($_GET['rig_name'])."'");
			OCIExecute($check_parse, OCI_DEFAULT);
			OCIFetch($check_parse);
			if(!strcmp($_GET['rig_name'], OCIResult($check_parse, 'RIG_NAME')))
			{
				$_SESSION['error']='Такая оснастка уже существует';
			}
			else
			{
				$ins_parse = OCIParse($connect, "INSERT INTO rig (rig_name, rig_type)
							VALUES ('".trim($_GET['rig_name'])."', '".trim($_GET['rig_type'])."')");
				OCIExecute($ins_parse, OCI_DEFAULT);
				OCICommit($connect);
				$_SESSION['error']='Оснастка добавлена';
			}
		}
	}
?>
<html>

<head>
	<meta charset="utf8">
	<link href="../style.css" rel="stylesheet">
	<title>Добавить оснастку</title>
	
</head>

<header>
	АСУ ТП изготовления "Датчик уровня воды"<br>
	Добавление оснастки
</header>

<body>
	<div class="mainbody">
		<div class="menu">
			<?php
				echo "Добро пожаловать, ".$_SESSION['user']."<br>Ваша роль: ".$_SESSION['user_role']."<br>";
			?>
			<a href="rig.php">Назад</a><br>
			<br>
			<a href="../index.php">На главную</a><br>
			<ul>
				<?php
					if(!strcmp($_SESSION['user_role'], 'administrator')||!strcmp($_SESSION['user_role'], 'moderator'))
					{
						echo "<li><a href='../users/users.php'>Управление пользователями</a></li>";
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
			<form action="insert_rig.php" method="GET" class="authform">
				Введите название<br>
				<input type='textarea' class='login' name='rig_name'><br>
				Введите тип<br>
				<input type='textarea' class='login' name='rig_type'><br><br>
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
			unset($sql_parse, $_POST['ok'], $_SESSION['error']);
			require ("../disconnect.php");
		?>
	</div>
	<div class="footer">
			© Миронов Кирилл ИУ4-83Б
	</div>
</body>

</html>