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
		$sel_parse = OCIParse($connect, "SELECT * FROM devices WHERE
								dev_id = ".(int)$_GET['dev_id']."");
		OCIExecute($sel_parse, OCI_DEFAULT);
		OCIFetch($sel_parse);
		if(!trim($_GET['dev_name']))
		{
			$dev_name = OCIResult($sel_parse, 'DEV_NAME');
		}
		else
		{
			$dev_name = trim($_GET['dev_name']);
		}
		
		if(!trim($_GET['dev_odate']))
		{
			$dev_odate = OCIResult($sel_parse, 'DEV_ODATE');
		}
		else
		{
			$dev_odate = trim($_GET['dev_odate']);
		}
		
		if(!trim($_GET['dev_defects']))
		{
			$dev_defects = OCIResult($sel_parse, 'DEV_DEFECTS');
		}
		else
		{
			$dev_defects = trim($_GET['dev_defects']);
		}
		
		$upd_parse = OCIParse($connect, "UPDATE devices 
					SET dev_name = '".$dev_name."'
					, dev_odate = TO_DATE('".$dev_odate."', 'dd.mm.yyyy')
					, dev_defects = '".$dev_defects."'
					WHERE dev_id = ".(int)$_GET['dev_id']."");
		OCIExecute($upd_parse, OCI_DEFAULT);
		OCICommit($upd_parse);
		$_SESSION['error'] = 'Изменение успешно';
	}
?>

<html>

<head>
	<meta charset="utf8">
	<link href="../style.css" rel="stylesheet">
	<title>Изменение устройства</title>
	
</head>

<header>
	АСУ ТП изготовления "Датчик уровня воды"<br>
	Изменение устройства
</header>

<body>
	<div class="mainbody">
		<div class="menu">
			<?php
				echo "Добро пожаловать, ".$_SESSION['user']."<br>Ваша роль: ".$_SESSION['user_role']."<br>";
			?>
			<a href="devices.php">Назад</a><br>
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
			<form action="edit_devices.php" method="GET" class="authform">
				Выберите название изменяемого устройства<br>
				<select class='roles' name='dev_id'>
					<?php
						$sql_parse = OCIParse($connect , "SELECT * FROM devices");
						OCIExecute($sql_parse, OCI_DEFAULT);
						while(OCIFetch($sql_parse))
						{
							echo "<option value=".OCIResult($sql_parse, 'DEV_ID').">".OCIResult($sql_parse, 'DEV_NAME')."</option>";
						}
					?>
				</select><br><br>
				Введите название<br>
				<input type='textarea' class='login' name='dev_name'><br>
				Введите дату (dd.mm.yyyy)<br>
				<input type='textarea' class='login' name='dev_odate'><br>
				Введите брак<br>
				<input type='textarea' class='login' name='dev_defects'><br><br>
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