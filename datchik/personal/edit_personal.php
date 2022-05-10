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
		$sel_parse = OCIParse($connect, "SELECT * FROM personal WHERE
								per_id = ".(int)$_GET['per_id']."");
		OCIExecute($sel_parse, OCI_DEFAULT);
		OCIFetch($sel_parse);
		if(!trim($_GET['per_surname']))
		{
			$per_surname = OCIResult($sel_parse, 'PER_SURNAME');
		}
		else
		{
			$per_surname = trim($_GET['per_surname']);
		}
		
		if(!trim($_GET['per_name']))
		{
			$per_name = OCIResult($sel_parse, 'PER_NAME');
		}
		else
		{
			$per_name = trim($_GET['per_name']);
		}
		
		if(!trim($_GET['per_lastname']))
		{
			$per_lastname = OCIResult($sel_parse, 'PER_LASTNAME');
		}
		else
		{
			$per_lastname = trim($_GET['per_lastname']);
		}
		
		if(!trim($_GET['per_adr']))
		{
			$per_adr = OCIResult($sel_parse, 'PER_ADR');
		}
		else
		{
			$per_adr = trim($_GET['per_adr']);
		}
		
		if(!trim($_GET['per_job']))
		{
			$per_job = OCIResult($sel_parse, 'PER_JOB');
		}
		else
		{
			$per_job = trim($_GET['per_job']);
		}
		
		$upd_parse = OCIParse($connect, "UPDATE personal 
					SET per_surname = '".$per_surname."'
					, per_name = '".$per_name."'
					, per_lastName = '".$per_lastname."'
					, per_adr = '".$per_adr."'
					, per_job = '".$per_job."'
					WHERE per_id = ".(int)$_GET['per_id']."");
		OCIExecute($upd_parse, OCI_DEFAULT);
		OCICommit($upd_parse);
		$_SESSION['error'] = 'Изменение успешно';
	}
?>

<html>

<head>
	<meta charset="utf8">
	<link href="../style.css" rel="stylesheet">
	<title>Изменение персонала</title>
	
</head>

<header>
	АСУ ТП изготовления "Датчик уровня воды"<br>
	Изменение персонала
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
			<form action="edit_personal.php" method="GET" class="authform">
				Выберите название изменяемого персонала<br>
				<select class='roles' name='per_id'>
					<?php
						$sql_parse = OCIParse($connect , "SELECT * FROM personal");
						OCIExecute($sql_parse, OCI_DEFAULT);
						while(OCIFetch($sql_parse))
						{
							echo "<option value=".OCIResult($sql_parse, 'PER_ID').">".OCIResult($sql_parse, 'PER_SURNAME')." ".OCIResult($sql_parse, 'PER_NAME')." ".OCIResult($sql_parse, 'PER_LASTNAME')."</option>";
						}
					?>
				</select><br><br>
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
			unset($sql_parse, $_SESSION['error']);
			require ("../disconnect.php");
		?>
	</div>
	<div class="footer">
			© Миронов Кирилл ИУ4-83Б
	</div>
</body>

</html>