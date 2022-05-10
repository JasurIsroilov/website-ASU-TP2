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
	<title>Операции</title>
	
</head>

<header>
	АСУ ТП изготовления "Датчик уровня воды"<br>
	Операции
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
						<li><a href='pdf_operations.php'>PDF-отчет операции</a></li>
						<li><a href='insert_operations.php'>Добавить операцию</a></li>";
						if(!strcmp($_SESSION['user_role'], 'administrator')||!strcmp($_SESSION['user_role'], 'moderator'))
						{
							echo "<li><a href='edit_operations.php'>Изменить операцию</a></li>";
						}
						if(!strcmp($_SESSION['user_role'], 'administrator')||!strcmp($_SESSION['user_role'], 'moderator'))
						{
							echo "<li><a href='delete_operations.php'>Удалить операцию</a></li>";
						}
					echo "
					</ul>
				</div>
				<h3 align='center'>Операции</h3>
				<table>
					<thead>
						<tr>
							<td>ID</td>
							<td>Тип</td>
							<td>Стоимость $</td>
							<td>Длительность, с</td>
							<td>Документ</td>
							<td>Персонал</td>
							<td>Оборудование</td>
							<td>Оснастка</td>
						</tr>	
					</thead>";
						require("../connect.php");
						$mysql_parse = OCIParse($connect,'SELECT * FROM operations ORDER BY oper_id');
						OCIExecute($mysql_parse, OCI_DEFAULT);
						echo "<tbody>";
							while(OCIFetch($mysql_parse))
							{
								echo "<tr>
									<td>".OCIResult($mysql_parse, 'OPER_ID')."</td>
									<td>".OCIResult($mysql_parse, 'OPER_TYPE')."</td>
									<td>".OCIResult($mysql_parse, 'OPER_COST')."</td>
									<td>".OCIResult($mysql_parse, 'OPER_DUR')."</td>";
									
									$sel_parse = OCIParse($connect, "SELECT doc_name FROM documents WHERE doc_id = ".OCIResult($mysql_parse, 'OPER_DOC_ID')."");
									OCIExecute($sel_parse, OCI_DEFAULT);
									OCIFetch($sel_parse);
									echo "<td>".OCIResult($sel_parse, 'DOC_NAME')."</td>";
									
									$sel_parse = OCIParse($connect, "SELECT * FROM personal WHERE per_id = ".OCIResult($mysql_parse, 'OPER_PER_ID')."");
									OCIExecute($sel_parse, OCI_DEFAULT);
									OCIFetch($sel_parse);
									echo "<td>".OCIResult($sel_parse, 'PER_SURNAME')." ".OCIResult($sel_parse, 'PER_NAME')." ".OCIResult($sel_parse, 'PER_LASTNAME')."</td>";
									
									$sel_parse = OCIParse($connect, "SELECT equ_name FROM equipment WHERE equ_id = ".OCIResult($mysql_parse, 'OPER_EQU_ID')."");
									OCIExecute($sel_parse, OCI_DEFAULT);
									OCIFetch($sel_parse);
									echo "<td>".OCIResult($sel_parse, 'EQU_NAME')."</td>";
									
									$sel_parse = OCIParse($connect, "SELECT rig_name FROM rig WHERE rig_id = ".OCIResult($mysql_parse, 'OPER_RIG_ID')."");
									OCIExecute($sel_parse, OCI_DEFAULT);
									OCIFetch($sel_parse);
									echo "<td>".OCIResult($sel_parse, 'RIG_NAME')."</td>
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