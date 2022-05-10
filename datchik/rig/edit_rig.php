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
		$sel_parse = OCIParse($connect, "SELECT * FROM rig WHERE
								rig_name = '".$_GET['old_rig_name']."'");
		OCIExecute($sel_parse, OCI_DEFAULT);
		OCIFetch($sel_parse);
		if(!trim($_GET['rig_name']))
		{
			$rig_name = OCIResult($sel_parse, 'RIG_NAME');
		}
		else
		{
			$rig_name = trim($_GET['rig_name']);
		}
		
		if(!trim($_GET['rig_type']))
		{
			$rig_type = OCIResult($sel_parse, 'RIG_TYPE');
		}
		else
		{
			$rig_type = trim($_GET['rig_type']);
		}
		
		$upd_parse = OCIParse($connect, "UPDATE rig 
					SET rig_name = '".$rig_name."'
					, rig_type = '".$rig_type."'
					WHERE rig_name = '".$_GET['old_rig_name']."'");
		OCIExecute($upd_parse, OCI_DEFAULT);
		OCICommit($upd_parse);
		$_SESSION['error'] = 'Изменение успешно';
	}
?>

<html>

<head>
	<meta charset="utf8">
	<link href="../style.css" rel="stylesheet">
	<title>Изменение оснастки</title>
	
</head>

<header>
	АСУ ТП изготовления "Датчик уровня воды"<br>
	Изменение оснастки
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
			<form action="edit_rig.php" method="GET" class="authform">
				Выберите название изменяемой оснастки<br>
				<select class='roles' name='old_rig_name'>
					<?php
						$sql_parse = OCIParse($connect , "SELECT * FROM rig");
						OCIExecute($sql_parse, OCI_DEFAULT);
						while(OCIFetch($sql_parse))
						{
							echo "<option value=".OCIResult($sql_parse, 'RIG_NAME').">".OCIResult($sql_parse, 'RIG_NAME')."</option>";
						}
					?>
				</select><br><br>
				Введите новое название<br>
				<input type='textarea' class='login' name='rig_name'><br>
				Введите новый тип<br>
				<input type='textarea' class='login' name='rig_type'><br><br>
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