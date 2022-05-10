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
		if(!trim($_GET['oper_type']))
		{
			$_SESSION['error']='Введите тип';
		}
		elseif(!trim($_GET['oper_cost']))
		{
			$_SESSION['error']='Введите стоимость';
		}
		elseif(!trim($_GET['oper_dur']))
		{
			$_SESSION['error']='Введите длительность';
		}
		else
		{
			$check_parse = OCIParse($connect, "SELECT * FROM operations WHERE oper_type = '".trim($_GET['oper_type'])."'");
			OCIExecute($check_parse, OCI_DEFAULT);
			OCIFetch($check_parse);
			if(!strcmp($_GET['oper_type'], OCIResult($check_parse, 'OPER_TYPE')))
			{
				$_SESSION['error']='Такая операция уже существует';
			}
			else
			{
				$ins_parse = OCIParse($connect, "INSERT INTO operations (oper_type, oper_cost, oper_dur
							, oper_doc_id, oper_per_id, oper_equ_id, oper_rig_id)
							VALUES ('".trim($_GET['oper_type'])."'
								, ".(int)trim($_GET['oper_cost'])."
								, ".(int)trim($_GET['oper_dur'])."
								, ".(int)$_GET['oper_doc_id']."
								, ".(int)$_GET['oper_per_id']."
								, ".(int)$_GET['oper_equ_id']."
								, ".(int)$_GET['oper_rig_id'].")");
				OCIExecute($ins_parse, OCI_DEFAULT);
				OCICommit($connect);
				$_SESSION['error']='Операция добавлена';
			}
		}
	}
?>
<html>

<head>
	<meta charset="utf8">
	<link href="../style.css" rel="stylesheet">
	<title>Добавить операцмю</title>
	
</head>

<header>
	АСУ ТП изготовления "Датчик уровня воды"<br>
	Добавление операции
</header>

<body>
	<div class="mainbody">
		<div class="menu">
			<?php
				echo "Добро пожаловать, ".$_SESSION['user']."<br>Ваша роль: ".$_SESSION['user_role']."<br>";
			?>
			<a href="operations.php">Назад</a><br>
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
			<form action="insert_operations.php" method="GET" class="authform">
				Введите тип<br>
				<input type='textarea' class='login' name='oper_type'><br>
				Введите стоимость<br>
				<input type='textarea' class='login' name='oper_cost'><br>
				Введите длительность<br>
				<input type='textarea' class='login' name='oper_dur'><br>
				Выберите документ<br>
				<select class='roles' name='oper_doc_id'>
					<?php
						$sql_parse = OCIParse($connect , "SELECT * FROM documents");
						OCIExecute($sql_parse, OCI_DEFAULT);
						while(OCIFetch($sql_parse))
						{
							echo "<option value=".OCIResult($sql_parse, 'DOC_ID').">".OCIResult($sql_parse, 'DOC_NAME')."</option>";
						}
					?>
				</select><br>
				
				Выберите персонал<br>
				<select class='roles' name='oper_per_id'>
					<?php
						$sql_parse = OCIParse($connect , "SELECT * FROM personal");
						OCIExecute($sql_parse, OCI_DEFAULT);
						while(OCIFetch($sql_parse))
						{
							echo "<option value=".OCIResult($sql_parse, 'PER_ID').">".OCIResult($sql_parse, 'PER_SURNAME')." ".OCIResult($sql_parse, 'PER_NAME')." ".OCIResult($sql_parse, 'PER_LASTNAME')."</option>";
						}
					?>
				</select><br>
				
				Выберите оборудование<br>
				<select class='roles' name='oper_equ_id'>
					<?php
						$sql_parse = OCIParse($connect , "SELECT * FROM equipment");
						OCIExecute($sql_parse, OCI_DEFAULT);
						while(OCIFetch($sql_parse))
						{
							echo "<option value=".OCIResult($sql_parse, 'EQU_ID').">".OCIResult($sql_parse, 'EQU_NAME')."</option>";
						}
					?>
				</select><br>
				
				Выберите оснастку<br>
				<select class='roles' name='oper_rig_id'>
					<?php
						$sql_parse = OCIParse($connect , "SELECT * FROM rig");
						OCIExecute($sql_parse, OCI_DEFAULT);
						while(OCIFetch($sql_parse))
						{
							echo "<option value=".OCIResult($sql_parse, 'RIG_ID').">".OCIResult($sql_parse, 'RIG_NAME')."</option>";
						}
					?>
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
			unset($sql_parse, $_POST['ok'], $_SESSION['error']);
			require ("../disconnect.php");
		?>
	</div>
	<div class="footer">
			© Миронов Кирилл ИУ4-83Б
	</div>
</body>

</html>