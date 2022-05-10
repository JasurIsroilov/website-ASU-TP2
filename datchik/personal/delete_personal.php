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
		$sql_parse = OCIParse($connect, "DELETE FROM personal WHERE per_id = ".(int)$_GET['per_id']."");
		OCIExecute($sql_parse, OCI_DEFAULT);
		OCICommit($connect);
		$_SESSION['error']='Персонал удален';	
	}
?>
<html>

<head>
	<meta charset="utf8">
	<link href="../style.css" rel="stylesheet">
	<title>Удаление персонала</title>
	
</head>

<header>
	АСУ ТП изготовления "Датчик уровня воды"<br>
	Удаление персонала
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
			<form action="delete_personal.php" method="GET" class="authform">
				Выберите название удаляемого персонала<br>
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
			unset($sql_parse, $_SESSION['error']);
			require ("../disconnect.php");
		?>
	</div>
	<div class="footer">
			© Миронов Кирилл ИУ4-83Б
	</div>
</body>

</html>