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
		$sel_parse = OCIParse($connect, "SELECT * FROM documents WHERE
								doc_id = ".(int)$_GET['doc_id']."");
		OCIExecute($sel_parse, OCI_DEFAULT);
		OCIFetch($sel_parse);
		if(!trim($_GET['doc_name']))
		{
			$doc_name = OCIResult($sel_parse, 'DOC_NAME');
		}
		else
		{
			$doc_name = trim($_GET['doc_name']);
		}
		
		if(!trim($_GET['doc_type']))
		{
			$doc_type = OCIResult($sel_parse, 'DOC_TYPE');
		}
		else
		{
			$doc_type = trim($_GET['doc_type']);
		}
		
		if(!trim($_GET['doc_date']))
		{
			$doc_date = OCIResult($sel_parse, 'DOC_DATE');
		}
		else
		{
			$doc_date = trim($_GET['doc_date']);
		}
		
		if(!trim($_GET['doc_dev_id']))
		{
			$doc_dev_id = OCIResult($sel_parse, 'DOC_DEV_ID');
		}
		else
		{
			$doc_dev_id = (int)trim($_GET['doc_dev_id']);
		}
		
		$upd_parse = OCIParse($connect, "UPDATE documents 
					SET doc_name = '".$doc_name."'
					, doc_type = '".$doc_type."'
					, doc_date = TO_DATE('".$doc_date."', 'dd.mm.yyyy')
					, doc_dev_id = ".$doc_dev_id."
					WHERE doc_id = ".(int)$_GET['doc_id']."");
		OCIExecute($upd_parse, OCI_DEFAULT);
		OCICommit($upd_parse);
		$_SESSION['error'] = 'Изменение успешно';
	}
?>

<html>

<head>
	<meta charset="utf8">
	<link href="../style.css" rel="stylesheet">
	<title>Изменение документа</title>
	
</head>

<header>
	АСУ ТП изготовления "Датчик уровня воды"<br>
	Изменение документа
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
			<form action="edit_documents.php" method="GET" class="authform">
				Выберите название изменяемого документа<br>
				<select class='roles' name='doc_id'>
					<?php
						$sql_parse = OCIParse($connect , "SELECT * FROM documents");
						OCIExecute($sql_parse, OCI_DEFAULT);
						while(OCIFetch($sql_parse))
						{
							echo "<option value=".OCIResult($sql_parse, 'DOC_ID').">".OCIResult($sql_parse, 'DOC_NAME')."</option>";
						}
					?>
				</select><br><br>
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