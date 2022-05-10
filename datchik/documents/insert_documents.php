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
		if(!trim($_GET['doc_name']))
		{
			$_SESSION['error']='Введите название';
		}
		elseif(!trim($_GET['doc_type']))
		{
			$_SESSION['error']='Введите тип';
		}
		elseif(!trim($_GET['doc_date']))
		{
			$_SESSION['error']='Введите дату';
		}
		else
		{
			$check_parse = OCIParse($connect, "SELECT * FROM documents WHERE doc_name = '".trim($_GET['doc_name'])."'");
			OCIExecute($check_parse, OCI_DEFAULT);
			OCIFetch($check_parse);
			if(OCIResult($check_parse, 'DOC_NAME'))
			{
				$_SESSION['error']='Такой документ уже существует';
			}
			else
			{

				$ins_parse = OCIParse($connect, "INSERT INTO documents (doc_name, doc_type, doc_date, doc_dev_id)
						VALUES ('".trim($_GET['doc_name'])."', '".trim($_GET['doc_type'])."'
						, TO_DATE('".$_GET['doc_date']."','dd.mm.yyyy')
						, ".(int)trim($_GET['doc_dev_id']).")");
				OCIExecute($ins_parse, OCI_DEFAULT);
				OCICommit($connect);
				$_SESSION['error']='Документ добавлен';
			}
		}
	}
?>
<html>

<head>
	<meta charset="utf8">
	<link href="../style.css" rel="stylesheet">
	<title>Добавить документ</title>
	
</head>

<header>
	АСУ ТП изготовления "Датчик уровня воды"<br>
	Добавление документ
</header>

<body>
	<div class="mainbody">
		<div class="menu">
			<?php
				echo "Добро пожаловать, ".$_SESSION['user']."<br>Ваша роль: ".$_SESSION['user_role']."<br>";
			?>
			<a href="documents.php">Назад</a><br>
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
			<form action="insert_documents.php" method="GET" class="authform">
				Введите название<br>
				<input type='textarea' class='login' name='doc_name'><br>
				Введите тип<br>
				<input type='textarea' class='login' name='doc_type'><br>
				Введите дату (dd.mm.yyyy)<br>
				<input type='textarea' class='login' name='doc_date'><br>
				Выберите устройство<br>
				<select class='roles' name='doc_dev_id'>
					<?php
						$sql_parse = OCIParse($connect , "SELECT * FROM devices");
						OCIExecute($sql_parse, OCI_DEFAULT);
						while(OCIFetch($sql_parse))
						{
							echo "<option value=".OCIResult($sql_parse, 'DEV_ID').">".OCIResult($sql_parse, 'DEV_NAME')."</option>";
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