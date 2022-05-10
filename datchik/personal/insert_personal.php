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
		if(!trim($_GET['per_surname']))
		{
			$_SESSION['error']='Введите фамилию';
		}
		elseif(!trim($_GET['per_name']))
		{
			$_SESSION['error']='Введите имя';
		}
		elseif(!trim($_GET['per_lastname']))
		{
			$_SESSION['error']='Введите отчество';
		}
		elseif(!trim($_GET['per_adr']))
		{
			$_SESSION['error']='Введите адрес';
		}
		elseif(!trim($_GET['per_job']))
		{
			$_SESSION['error']='Введите должность';
		}
		else
		{
			$check_parse = OCIParse($connect, "SELECT * FROM personal WHERE per_name = '".trim($_GET['per_name'])."'
						AND per_surname = '".trim($_GET['per_surname'])."' AND per_lastName = '".trim($_GET['per_lastname'])."'");
			OCIExecute($check_parse, OCI_DEFAULT);
			OCIFetch($check_parse);
			if(OCIResult($check_parse, 'PER_NAME'))
			{
				$_SESSION['error']='Такой персонал уже существует';
			}
			else
			{
				$ins_parse = OCIParse($connect, "INSERT INTO personal (per_surname, per_name, per_lastname, per_adr, per_job)
							VALUES ('".trim($_GET['per_surname'])."', '".trim($_GET['per_name'])."'
							, '".trim($_GET['per_lastname'])."', '".trim($_GET['per_adr'])."'
							, '".trim($_GET['per_job'])."')");
				OCIExecute($ins_parse, OCI_DEFAULT);
				OCICommit($connect);
				$_SESSION['error']='Персонал добавлен';
			}
		}
	}
?>
<html>

<head>
	<meta charset="utf8">
	<link href="../style.css" rel="stylesheet">
	<title>Добавить персонал</title>
	
</head>

<header>
	АСУ ТП изготовления "Датчик уровня воды"<br>
	Добавление персонала
</header>

<body>
	<div class="mainbody">
		<div class="menu">
			<?php
				echo "Добро пожаловать, ".$_SESSION['user']."<br>Ваша роль: ".$_SESSION['user_role']."<br>";
			?>
			<a href="personal.php">Назад</a><br>
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
			<form action="insert_personal.php" method="GET" class="authform">
				Введите фамилию<br>
				<input type='textarea' class='login' name='per_surname'><br>
				Введите имя<br>
				<input type='textarea' class='login' name='per_name'><br>
				Введите отчество<br>
				<input type='textarea' class='login' name='per_lastname'><br>
				Введите адрес<br>
				<input type='textarea' class='login' name='per_adr'><br>
				Введите должность<br>
				<input type='textarea' class='login' name='per_job'><br><br>
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