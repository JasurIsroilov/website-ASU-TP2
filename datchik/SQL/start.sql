SPOOL C:\ApacheDocs\mironov\SQL\start.log
--PROMPT Скрипт АСУ ТП изготовления модуля зарадки с защитой для li-ion аккумуляторов
--PROMPT Автор: Миронов К.С.
--PROMPT Дата создания 00.04.2022
	@@create_table.sql;
	@@create_pk.sql
	@@create_fk.sql
	@@create_sq.sql;
	@@create_tr.sql;
	@@insert.sql;
	COMMIT;
SPOOL off;