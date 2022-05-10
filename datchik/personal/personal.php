<?php
	session_start();
	if(!$_SESSION['user_role'])
	{
		header('Location: authorization.php');
		exit();
	}
	error_reporting( E_ERROR );
?>
<html>

<head>
	<meta charset="utf8">
	<link href="../style.css" rel="stylesheet">
	<title>Персонал</title>
	
</head>

<header>
	АСУ ТП изготовления "Датчик уровня воды"<br>
	Персонал
</header>

<body>
	<div class="mainbody">
		<div class="menu">
			<?php
				echo "Добро пожаловать, ".$_SESSION['user']."<br>Ваша роль: ".$_SESSION['user_role']."<br>";
			?>
			<a href="../index.php">Назад</a><br>
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
		<?php
			echo "
			<div class='content'>
				<div class='opt'>
					<ul>
						<li><a href='insert_personal.php'>Добавить персонал</a></li>";
						if(!strcmp($_SESSION['user_role'], 'administrator')||!strcmp($_SESSION['user_role'], 'moderator'))
						{
							echo "<li><a href='edit_personal.php'>Изменить персонал</a></li>";
						}
						if(!strcmp($_SESSION['user_role'], 'administrator')||!strcmp($_SESSION['user_role'], 'moderator'))
						{
							echo "<li><a href='delete_personal.php'>Удалить персонал</a></li>";
						}
					echo "
					</ul>
				</div>
				<h3 align='center'>Персонал</h3>
				<table>
					<thead>
						<tr>
							<td>ID</td>
							<td>Фамилия</td>
							<td>Имя</td>
							<td>Отчество</td>
							<td>Адрес</td>
							<td>Должность</td>
						</tr>	
					</thead>";
						require("../connect.php");
						$mysql_parse = OCIParse($connect,'SELECT * FROM personal ORDER BY per_id');
						OCIExecute($mysql_parse, OCI_DEFAULT);
						echo "<tbody>";
							while(OCIFetch($mysql_parse))
							{
								echo "<tr>
									<td>".OCIResult($mysql_parse, 'PER_ID')."</td>
									<td>".OCIResult($mysql_parse, 'PER_SURNAME')."</td>
									<td>".OCIResult($mysql_parse, 'PER_NAME')."</td>
									<td>".OCIResult($mysql_parse, 'PER_LASTNAME')."</td>
									<td>".OCIResult($mysql_parse, 'PER_ADR')."</td>
									<td>".OCIResult($mysql_parse, 'PER_JOB')."</td>
								</tr>";
							}
						echo "</tbody>
				</table>
			</div>";
			require ("../disconnect.php");
		?>
	</div>
	<div class="footer">
			© Миронов Кирилл ИУ4-83Б
	</div>
</body>

</html>