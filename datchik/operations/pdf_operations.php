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
	require('../fpdf/fpdf.php');   //Подключение класса FPDF
		$pdf=new FPDF();   //Создание экземпляра класса FPDF
		$pdf->AddFont('ArialRus', '', 'arial.php');   //Добавление шрифта Times New Roman
		$pdf->AddPage();   //Добавление новой страницы
		$pdf->Image('../fpdf/mmap.png', 0, 0, 210, 297);   //Вывод изображения (пустой бланк маршрутной карты)
		$pdf->SetFont('ArialRus', '', 12);   //Установка шрифта
	
	if(isset($_GET['ok']))
	{
		$step = 67;
		$sql_parse = OCIParse($connect, "SELECT * FROM operations WHERE oper_type = '".trim($_GET['oper_type'])."'");
		OCIExecute($sql_parse, OCI_DEFAULT);
		OCIFetch($sql_parse);
		$_SESSION['error']='Успешно';
		
		$pdf->Text(80, 30, OCIResult($sql_parse, 'OPER_TYPE'));
		
		$sel_parse = OCIParse($connect, "SELECT * FROM personal WHERE per_id = ".OCIResult($sql_parse, 'OPER_PER_ID')."");
		OCIExecute($sel_parse, OCI_DEFAULT);
		OCIFetch($sel_parse);
		$pdf->Text(140, 265, OCIResult($sel_parse,'PER_SURNAME') ." ".OCIResult($sel_parse,'PER_NAME'));
		$pdf->Text(140, 270, 'Vlasov A.I.');
		
		$sel_parse = OCIParse($connect, "SELECT * FROM documents WHERE doc_id = ".OCIResult($sql_parse, 'OPER_DOC_ID')."");
		OCIExecute($sel_parse, OCI_DEFAULT);
		OCIFetch($sel_parse);
		$pdf->Text(70, 40, OCIResult($sel_parse,'DOC_NAME').", ".OCIResult($sel_parse,'DOC_TYPE'));
		
		$sel_parse = OCIParse($connect, "SELECT * FROM equipment WHERE equ_id = ".OCIResult($sql_parse, 'OPER_EQU_ID')."");
		OCIExecute($sel_parse, OCI_DEFAULT);
		OCIFetch($sel_parse);
		$pdf->Text(90, 46, OCIResult($sel_parse, 'EQU_NAME') .", ". OCIResult($sel_parse, 'EQU_TYPE'));
		
		$sel_parse = OCIParse($connect, "SELECT * FROM rig WHERE rig_id = ".OCIResult($sql_parse, 'OPER_RIG_ID')."");
		OCIExecute($sel_parse, OCI_DEFAULT);
		OCIFetch($sel_parse);
		$pdf->Text(130, 56, OCIResult($sel_parse, 'RIG_NAME') .", ". OCIResult($sel_parse, 'RIG_TYPE'));
		
		$all_parse = OCIParse($connect, "SELECT oper_type FROM operations");
		OCIExecute($all_parse, OCI_DEFAULT);
		while(OCIFetch($all_parse))
		{
			$pdf->Text(25, $step, OCIResult($all_parse, 'OPER_TYPE'));
			$step = $step + 7;
		}
		$pdf->Output('operations.pdf');
	}
?>
<html>

<head>
	<meta charset="utf8">
	<link href="../style.css" rel="stylesheet">
	<title>PDF-отчет операции</title>
	
</head>

<header>
	АСУ ТП изготовления "Датчик уровня воды"<br>
	PDF-отчет операции
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
			<form action="pdf_operations.php" method="GET" class="authform">
				Выберите тип операции<br>
				<select class='roles' name='oper_type'>
					<?php
						$sql_parse = OCIParse($connect , "SELECT * FROM operations");
						OCIExecute($sql_parse, OCI_DEFAULT);
						while(OCIFetch($sql_parse))
						{
							echo "<option value=".OCIResult($sql_parse, 'OPER_TYPE').">".OCIResult($sql_parse, 'OPER_TYPE')."</option>";
						}
					?>
				</select><br><br>
				<input type='submit'   class='ok' value='PDF' name='ok'></submit><br><br>
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